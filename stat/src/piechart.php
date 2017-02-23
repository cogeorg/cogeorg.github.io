<?php
/*

>>>>>> CrazyStat <<<<<<
A convenient, comprehensive and free PHP statistic-Script with optional counter.

Copyright (C) 2004-2011  Christopher Kramer

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

E-Mail: webmaster AT christosoft DOT de
Web: http://www.christosoft.de
Version: 1.70

*** src/piechart.php ***
Funktion:    erzeugt Kreisdiagramm
Aufrufbar:   nein
Eingebunden: von src/show_stat.php (als Bild)
*/


session_start();
require_once('config_default.php');
require_once('../usr/config.php');
if(!$config_stat_lang_fix)
 {
 if(isset($_GET['lang']) && is_file('lang/'.basename($_GET['lang']).'.php'))  $_SESSION['lang']=basename($_GET['lang']);
 elseif(isset($_POST['lang']) && is_file('lang/'.basename($_POST['lang']).'.php'))  $_SESSION['lang']=basename($_POST['lang']);
 elseif(isset($_SESSION['lang']) && is_file('lang/'.basename($_SESSION['lang']).'.php'))  ;
 elseif(isset($_COOKIE['lang']) && is_file('lang/'.basename($_COOKIE['lang']).'.php'))  $_SESSION['lang']=basename($_COOKIE['lang']);
 else $_SESSION['lang']=$config_stat_lang;
 setcookie('lang',$_SESSION['lang'],time()+3600*90);
 $config_stat_lang=$_SESSION['lang'];
 }
require_once('lang/'.$config_stat_lang.'.php');


if(!isset($_GET['modul'])) die(L_MSG_ERR_NO_MODULE.' '.L_MSG_ERR_INCLUDE_ONLY);

if(isset($_GET['size']) && is_numeric($_GET['size'])) $breite=$_GET['size'];
else $breite=$config_stat_pie_size;
$hoehe=$breite;

// Fuer Kantenglaettung
if(!is_callable('imagecreatetruecolor') || !is_callable('imagecopyresampled')) $glaett_faktor=1;
else $glaett_faktor=4;
$orig_breite=$breite;
$orig_hoehe=$hoehe;
$breite*=$glaett_faktor;
$hoehe*=$glaett_faktor;


if(!isset($_SESSION['module_'.$_GET['modul'].'_data']))
 {
 header('Content-type: image/png');
 $handle=imagecreate($orig_breite,$orig_hoehe);
 $mes_farbe=imagecolorallocate($handle,255,255,255);
 $mes_farbe=imagecolorallocate($handle,255,0,0);
 imagestring($handle,1,1,1,'FEHLER',$mes_farbe);
 imagestring($handle,1,1,15,'Keine Daten',$mes_farbe);
 imagepng($handle);
 imagedestroy($handle);
 exit;
 }
$werte=$_SESSION['module_'.$_GET['modul'].'_data'];


$farben=$config_stat_pie_colors;
if(!isset($werte)) $werte[]=0;

$diagramm=imagecreate($breite,$hoehe);

$hoehe--;
$breite--;
$weiss=imagecolorallocate($diagramm, 255, 255, 255);
$schwarz=imagecolorallocate($diagramm, 0, 0, 0);


imagefilledrectangle($diagramm,0,0,$breite,$hoehe,$weiss);

foreach($farben as $nummer => $farbe)
 {
 $rgb=hex2rgb($farbe);
 $farben[$nummer]=imagecolorallocate($diagramm, $rgb[0],$rgb[1],$rgb[2]);
 }

// Kreis zeichnen fuer alte GDlib
imagearc($diagramm, round($breite/2), round($hoehe/2), $breite, $hoehe, 0, 360, $schwarz);

$grauton=0;
$winkel=270;    // top mid is 270 deegree, so we start here
$teil=0;
$over360=false; // have we crossed mid right (360 degree) once?
rsort($werte);

foreach($werte as $wert)
 {
 $wert=prozent($wert,$_SESSION['module_'.$_GET['modul'].'_total']);    // percentage

 if(!isset($farben[$teil]))
  {
  $grauton+=20;
  if($grauton>255) $grauton=0;
  $farben[$teil]=imagecolorallocate($diagramm,$grauton,$grauton,$grauton);
  }

 if($winkel>360)
  {
  $over360=true;
  $winkel-=360;
  }
 $wert=round(($wert/100)*360);  // degree

 if($wert>0 && (!$over360 || $winkel+$wert<=270))
  {
  // Tortenstueck zeichnen
  if(is_callable('imagefilledarc'))
   {
   @$ausfuellen=imagefilledarc($diagramm, round($breite/2), round($hoehe/2), $breite, $hoehe, $winkel, $winkel+$wert, $farben[$teil],IMG_ARC_EDGED);
   }
  else
   {
   // Tortenstuecke fuer GDlib <2.0.1 zeichnen
   $radius_x1=round(floor(($breite-2)/2)*cos($winkel/180*M_PI)+round($breite/2));
   $radius_y1=round(floor(($hoehe-2)/2)*sin($winkel/180*M_PI)+round($hoehe/2));
   @imageline($diagramm, round($hoehe/2), round($breite/2), $radius_x1, $radius_y1, $schwarz);
   // Neu ab 1.60 : Für alte GDLibs wird das Stück per "Flood-Fill"-Pixel gefüllt
   /*
        - Errechnen eines Pixels innerhalb des Stücks:
           $fill_x=round(floor(($breite-10)/2)*cos(($winkel+2)/180*M_PI)+round($breite/2));
           $fill_y=round(floor(($hoehe-10)/2)*sin(($winkel+2)/180*M_PI)+round($hoehe/2));
        - Verwenden eines universellen Pixels (Mitte oben):
        */
   $fill_x=floor($breite/2)-2;
   $fill_y=3;
   @imagefilltoborder ($diagramm,$fill_x,$fill_y,$schwarz,$farben[$teil]);
   }
  $winkel+=$wert;
  }
 $teil++;
 }


// Kreis erneut zeichnen (Linienstärke: $glaett_faktor, damit nach Glättung 1px)
for($i=0; $i<$glaett_faktor; $i++)
 imagearc($diagramm, round($breite/2), round($hoehe/2), $breite-$i, $hoehe-$i, 0, 360, $schwarz);

// Kantenglaettung
if(is_callable('imagecreatetruecolor') && is_callable('imagecopyresampled'))
 {
 $diagramm_geglaettet=imagecreatetruecolor($orig_breite, $orig_hoehe);
 imagecopyresampled($diagramm_geglaettet, $diagramm, 0, 0, 0, 0, $orig_breite, $orig_hoehe, $breite+1, $hoehe+1);
 }
else
 {
 // essentielle Funktionen fehlen (alte GDLib) => fallback-lösung
 $diagramm_geglaettet=imagecreate($orig_breite, $orig_hoehe);
 imagecopyresized ($diagramm_geglaettet, $diagramm, 0, 0, 0, 0, $orig_breite, $orig_hoehe, $breite+1, $hoehe+1);
 }


header('Content-type: image/png');
imagepng($diagramm_geglaettet);
imagedestroy($digramm_geglaettet);
imagedestroy($diagramm);

// Hex in RGB umwandeln
function hex2rgb($hex)
 {
 $rgb[0]=hexdec(substr($hex,1,2));
 $rgb[1]=hexdec(substr($hex,3,2));
 $rgb[2]=hexdec(substr($hex,5,2));
 return($rgb);
 }

// Prozent-Funktion
function prozent($teil, $gesamt)
 {
 if($gesamt==0) return 100;
 return @$teil/$gesamt*100;
 }
?>