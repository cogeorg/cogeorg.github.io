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

*** src/create_counter_image.php ***
Funktion:    erzeugt Countergrafik
Aufrufbar:   nein
Eingebunden: von src/stat.php (include)
*/

// Config-Datei wird eingelesen
require_once('config_default.php');
require_once('../usr/config.php');
require_once('lang/'.$config_stat_lang.'.php');

if(!function_exists('show_error')) die(L_MSG_ERR_INCLUDE_ONLY);

// PNG/Gif-Header wird gesendet
if($config_counter_transparency==true && is_callable("imagegif")) header("Content-type: image/gif");
else header('Content-type: image/png');
// Nicht Cachen
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
// Auslesen des Counterstands
if($config_counter_reload==false && isset($anzahl_hits)) $counter_value=$anzahl_hits+1;
elseif($config_counter_reload==true && isset($anzahl_hits_ip)) $counter_value=$anzahl_hits_ip;
else $counter_value=1;

$counter_value+=$config_counter_add;

// Countergrafik-Pfad
$counter_quell_datei_name='../usr/'.$config_counter_folder.'/'.$config_counter_file_name;
if(!is_file($counter_quell_datei_name)) show_error(L_COUNTER_FILE_NOT_FOUND);
// Countergrafik-Groesse und Typ wird ausgelesen
@$counter_quell_datei_groesse=getimagesize($counter_quell_datei_name);
$counter_quell_datei_breite=$counter_quell_datei_groesse[0];
$counter_hoehe=$counter_quell_datei_groesse[1];
$counter_quell_datei_typ=$counter_quell_datei_groesse['mime'];
// Breite einer Ziffer wird errechnet
$counter_ziffernbreite=round($counter_quell_datei_breite/10);
// Breite des gesamt-Counters wird ermittelt
$counter_breite=$counter_ziffernbreite*$config_counter_digits;
// Neues Bild wird erstellt, Quellbild geoeffnet
@$counter_bild_handle=imagecreate($counter_breite,$counter_hoehe);
if($counter_quell_datei_typ=="image/png") $counter_bild_quelle_handle=imagecreatefrompng($counter_quell_datei_name);
elseif($counter_quell_datei_typ=="image/gif" && is_callable('imagecreatefromgif')) $counter_bild_quelle_handle=imagecreatefromgif($counter_quell_datei_name);
elseif(!is_callable('imagecreatefromgif') && $counter_quell_datei_typ=='image/gif') show_error(L_COUNTER_GIF_NOT_SUPPORTED);
else show_error(L_COUNTER_TYPE_NOT_SUPPORTED);
// Vornullen werden angefuegt
if(strlen($counter_value)<$config_counter_digits)
 {
 while(strlen($counter_value)<$config_counter_digits)
  {
  $counter_value="0".$counter_value;
  }
 }
 
// Ziffern werden auseinander genommen
$counter_value=chunk_split($counter_value,1,' ');
$counter_value=explode(' ',$counter_value);
// fuer jede Ziffer wird die Entsprechende Grafik aus der Countergrafik kopiert
foreach($counter_value as $counter_stelle => $counter_ziffer)
 {
  {
  $counter_ziffer_X=$counter_ziffernbreite*$counter_stelle;
  $counter_ziffer_qx=$counter_ziffernbreite*$counter_ziffer;
  imagecopy($counter_bild_handle,$counter_bild_quelle_handle,$counter_ziffer_X,0,$counter_ziffer_qx,0,$counter_ziffernbreite,$counter_hoehe);
  }
 }


// Reload-Text einfuegen falls aktiviert
if(!isset($counter_reload)) $counter_reload=false;
if($config_counter_reload==true && $config_counter_reload_show==true && $counter_reload==true)
 {
 // farbe, hoehe, breite auslesen/errechnen
 $mes_farbe=imagecolorallocate($counter_bild_handle,$config_counter_reload_show_col["r"],$config_counter_reload_show_col["g"],$config_counter_reload_show_col["b"]);
 $mes_breite=imagefontwidth($config_counter_reload_show_size)*strlen($config_counter_reload_show_text);
 $mes_hoehe=imagefontheight($config_counter_reload_show_size);
 // position auslesen und umrechnen
 if($config_counter_reload_show_pos["x"]<0 && $config_counter_reload_show_pos["x"]>(-1)) $config_counter_reload_show_pos["x"]=1-($config_counter_reload_show_pos["x"]*(-1));
 if($config_counter_reload_show_pos["y"]<0 && $config_counter_reload_show_pos["y"]>(-1)) $config_counter_reload_show_pos["y"]=1-($config_counter_reload_show_pos["y"]*(-1));
 if($config_counter_reload_show_pos["x"]>=1) $mes_x=$config_counter_reload_show_pos["x"];
 elseif($config_counter_reload_show_pos["x"]<=(-1)) $mes_x=$counter_breite-$config_counter_reload_show_pos["x"];
 elseif($config_counter_reload_show_pos["x"]>0 && $config_counter_reload_show_pos["x"]<1) $mes_x=round(($counter_breite*$config_counter_reload_show_pos["x"])-($mes_breite*$config_counter_reload_show_pos["x"]));
 else $mes_x=0;
 if($config_counter_reload_show_pos["y"]>=1) $mes_y=$config_counter_reload_show_pos["y"];
 elseif($config_counter_reload_show_pos["y"]<=(-1)) $mes_y=$counter_hoehe-$config_counter_reload_show_pos["y"];
 elseif($config_counter_reload_show_pos["y"]>0 && $config_counter_reload_show_pos["y"]<1) $mes_y=round(($counter_hoehe*$config_counter_reload_show_pos["y"])-($mes_hoehe*$config_counter_reload_show_pos["y"]));
 elseif($config_counter_reload_show_pos["y"]<0 && $config_counter_reload_show_pos["y"]>(-1)) $mes_y=round($counter_hoehe-(($counter_hoehe*$config_counter_reload_show_pos["y"]*-1)-($mes_hoehe*$config_counter_reload_show_pos["y"]*-1)));
 else $mes_y=0;
 // Einfuegen des Reload-Texts (eventuell mit Kasten)
 if($config_counter_reload_show_back==true)
  {
  $mes_back_farbe=imagecolorallocate($counter_bild_handle,$config_counter_reload_show_back_col["r"],$config_counter_reload_show_back_col["g"],$config_counter_reload_show_back_col["b"]);
  imagefilledrectangle($counter_bild_handle,$mes_x-2,$mes_y-2,$mes_x+$mes_breite+1,$mes_y+$mes_hoehe+1,$mes_back_farbe);
  }
 imagestring($counter_bild_handle,$config_counter_reload_show_size,$mes_x,$mes_y,$config_counter_reload_show_text,$mes_farbe);
 }

// Wenn der Counter transparent sein soll wird die Farbe von Pixel 1*1 transparent gesetzt
if($config_counter_transparency==true)
 {
 $counter_transparent = imagecolorat ($counter_bild_handle,0,0);
 imagecolortransparent($counter_bild_handle, $counter_transparent);
 }
// Bild wird erstellt
if($config_counter_transparency==true && is_callable('imagegif')) imagegif($counter_bild_handle); // gif bei Transparenz falls verfuegbar
else imagepng($counter_bild_handle);
imagedestroy($counter_bild_handle);
?>