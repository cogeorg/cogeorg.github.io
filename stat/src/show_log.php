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

*** src/show_log.php ***
Funktion:    erzeugt Ansicht der Logdatei als Text/Tabelle
Aufrufbar:   ja
Eingebunden: von src/show_stat.php (Link)
*/
require_once('general_include.php');
if(empty($config_stat_log_rows)) $config_stat_log_rows=40;
ignore_user_abort(false);
// Erhoehe Ram-Limit
@ini_set('memory_limit', '60M');


if((!isset($_REQUEST['id']) && !isset($_SESSION['log_ids'])) || (isset($_POST['button']) && $_POST['button']==L_CANCEL))
 {
 header('Location: http://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/logs.php?'.SIDX);
 exit;
 }
// detect agent?

if(isset($_GET['detect_agent']) && !$_GET['detect_agent']) $_SESSION['log_detect_agent']=false;
elseif(isset($_GET['detect_agent']) || !isset($_SESSION['log_detect_agent'])) $_SESSION['log_detect_agent']=true;

// suche/Filter?
if(isset($_REQUEST['aktion']) && $_REQUEST['aktion']=='search')
 {
 $search=true;
 $_SESSION['log_richtung']='vor';
 unset($_SESSION['log_seite']);
 }
else $search=false;

// seite & text-Einstellung
if(isset($_GET['seite']) && is_int(intval($_GET['seite']))) $seite=$_GET['seite'];
else $seite=0;
if(isset($_GET['text']) && $_GET['text']=='1') $text=true;
else $text=false;

// richtungs-einstellung
if(!isset($_SESSION['log_richtung'])) $_SESSION['log_richtung']='zur';
if(isset($_GET['richtung']) && ($_GET['richtung']=='vor' || $_GET['richtung']=='zur') && $_GET['richtung']!=$_SESSION['log_richtung'])
 {
 $_SESSION['log_richtung']=$_GET['richtung'];
 unset($_SESSION['log_seite']);
 }
$richtung=$_SESSION['log_richtung'];

// ID
if(isset($_REQUEST['id']))
 {
 $_SESSION['log_ids']=array($_REQUEST['id']);
 unset($_SESSION['log_seite']);
 }
$id_nr=0;


header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>CrazyStat - <?php echo L_SHOWLOG_TITLE; ?></title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
  td,th { border: 1px solid #000000; font-size: 8pt; font-family:Arial; }
  td.nav { border:0px; font-size: 10pt;  }
  a.reflinks { color:black; text-decoration:none; }
  a.reflinks:hover { color:black; text-decoration:underline; }
  body { padding-bottom: 15px; }
  tr.robot { color: rgb(80,80,80); }
  </style>
  <meta name="generator" content="CrazyStat" />
  <?php if($config_stat_ext_lytebox && is_file('extensions/lytebox.js') && is_file('extensions/lytebox.css')) { ?>
  <script type="text/javascript" language="javascript" src="extensions/lytebox.js"></script>
  <link rel="stylesheet" href="extensions/lytebox.css" type="text/css" media="screen" />
  <?php } ?>
  </head>
 <body>
  <div class="menue">
   <a href="about.php" target="_blank" rel="lyteframe" rev="width: 420px; height: 380px; scrolling: no;"><img src="img/about.png" alt="<?php echo L_MENU_ABOUT; ?>" title="<?php echo L_MENU_ABOUT; ?>" /></a>
   <a href="anonymous_redirect.php?go_anonym=<?php echo 'http://'.($config_stat_lang=='de'?'www':'en').'.christosoft.de'; ?>" target="_blank"><img src="img/website.png" alt="<?php echo L_MENU_WEBSITE; ?>" title="<?php echo L_MENU_WEBSITE; ?>" /></a>
   <a href="show_log.php?<?php echo SIDX.'&amp;seite='.$seite.'&amp;richtung='.$richtung.($search?'&amp;aktion=search':'').'&amp;'.time(); ?>" onclick="waitmessage();"><img src="img/refresh.png" alt="<?php echo L_REFRESH; ?>" title="<?php echo L_REFRESH; ?>" /></a>  
   <a href="logs.php?<?php echo SIDX; ?>"><img src="img/logs.png" alt="<?php echo L_SHOWLOG_ALLLOGS; ?>" title="<?php echo L_SHOWLOG_ALLLOGS; ?>" /></a>
   <?php if($config_stat_password_protect) { ?>
   <a href="show_log.php?<?php echo SIDX; ?>&amp;logout=true"><img src="img/logout.png" alt="<?php echo L_LOGOUT; ?>" title="<?php echo L_LOGOUT; ?>" /></a>
   <?php } ?>
  </div>
  <h1><img src="img/crazystat.gif" alt="CrazyStat" title="" width="146" height="35" /></h1>

<?php


if(!isset($_SESSION['log_files'][$_SESSION['log_ids'][$id_nr]])) die(L_MSG_ERR.': '.L_SHOWLOG_MSG_ERR_INVALID_ID.'<br /><a href="logs.php?'.SIDX.'">'.L_SHOWLOG_ALLLOGS.'</a>');
 
// Browserdatei einlesen
$browsers=file('../usr/keywords/browser.txt');
$i=0;
while(isset($browsers[$i]))
 {
 if(strstr($browsers[$i],'='))
  {
  $browser_string[$i]=trim(substr($browsers[$i],0,strpos($browsers[$i],'=')));
  $browser_name[$i]=trim(substr($browsers[$i],strpos($browsers[$i],'=')+1));
  }
 else
  {
  $browser_string[$i]=trim($browsers[$i]);
  $browser_name[$i]=trim($browsers[$i]);
  }
 $i++;
 }
$browser_anz=$i-1;
// Systeme-datei einlesen
$systems=file('../usr/keywords/os.txt');
$i=0;
while(isset($systems[$i]))
 {
 if(strstr($systems[$i],'='))
  {
  $system_string[$i]=trim(substr($systems[$i],0,strpos($systems[$i],'=')));
  $system_name[$i]=trim(substr($systems[$i],strpos($systems[$i],'=')+1));
  }
 else
  {
  $system_string[$i]=trim($systems[$i]);
  $system_name[$i]=trim($systems[$i]);
  }
 $i++;
 }
$system_anz=$i-1;
// Read Robots-File
$robots=file('../usr/keywords/robots.txt');
foreach($robots as $i=>$robot)
 {
 $robots[$i]=trim($robot);
 }
 

while(isset($_SESSION['log_files'][$_SESSION['log_ids'][$id_nr]]))
 {
 $id=$_SESSION['log_ids'][$id_nr];
 if($_SESSION['log_files'][$id]==$config_count_file)
  {
  $id_nr++;
  continue;
  }
 $logdatei_name='../usr/'.$config_logfile_folder.'/'.$_SESSION['log_files'][$id];

 echo '<h2>'.basename($logdatei_name).($search?' ('.L_SHOWLOG_FILTERED.')':'').'</h2>';

 if(!is_file($logdatei_name)) die('<h2>'.L_MSG_ERR.'</h2><p>'.L_SHOWLOG_MSG_ERR_LOGFILE_NOTFOUND.' '.$logdatei_name.'<br /><a href="logs.php?'.SIDX.'">'.L_SHOWLOG_ALLLOGS.'</a></p>');

 // Jumping (fseek) in .gz-files is incredibly slow -> uncompress the whole file temporarily
 if(strpos($logdatei_name, '.gz')!==false)
  {
  $fh_comp=fopen('compress.zlib://'.$logdatei_name,'r');
  $logdatei=tmpfile();
  while(!feof($fh_comp)) fwrite($logdatei, fgets($fh_comp));
  fclose($fh_comp);
  $unc_filesize=ftell($logdatei);
  rewind($logdatei);
  }
 else
  {
  $logdatei=open_logfile($logdatei_name,'r');
  $unc_filesize=filesize($logdatei_name);
  }
 
 // logseite
 if($richtung=='zur')
  {
  if(isset($_SESSION['log_seite'][0]) && $_SESSION['log_seite'][0]!=$unc_filesize) unset($_SESSION['log_seite']);
  $_SESSION['log_seite'][0]=$unc_filesize;
  } 
 elseif(!isset($_SESSION['log_seite'])) $_SESSION['log_seite'][0]=0;
 if(!isset($_SESSION['log_seite'][$seite]))
  {
  $start=finde_zeiger_pos($seite);
  $_SESSION['log_seite'][$seite]=$start;
  }

 // Nav
 if(!$search)
  {
  $nav=make_nav(); // Navigation erstellen
  echo $nav;       // Nav. ausgeben
  }

 if($text) echo '<div style="font-family:monospace, Courier; font-size:8pt; letter-spacing:-0.05em; white-space:nowrap">';
 else
  {
  echo '<table style="border-collapse:collapse; width:100%">'."\n"
      .'<thead><tr><th>'.L_NUMBER.'</th><th>'.L_TIME.'</th><th>'.L_DATE.'</th><th>'.L_IP.'</th><th>'.L_MODULES_FILE_S.'</th><th>'
      .'<a href="show_log.php?'.SIDX.'&amp;detect_agent='.($_SESSION['log_detect_agent']?0:1).($search?'&amp;aktion=search':'').'&amp;seite='.$seite.'&amp;richtung='.$richtung.'">'
      .($_SESSION['log_detect_agent']?L_MODULES_BROWSER_S.'/'.L_MODULES_SYSTEM_S:L_USERAGENT).'</a></th><th>'.L_MODULES_RESOLUTION_S.'</th><th>'.L_MODULES_COLORDEPTH_S.'</th><th>'.L_MODULES_REFERER_S.'</th></tr></thead><tbody>';
  }

 fseek($logdatei,$_SESSION['log_seite'][$seite]); // setze dateizeiger auf startposition der seite

 $i=0;
 while($i<$config_stat_log_rows || $search) // gebe $config_stat_log_rows zeilen aus
  {
  $i++;
  if($richtung=='zur') // falls richtung rueckw., setzte zeiger auf letzten zeilenumbruch
   {
   $seek=1;
   while(fgetc($logdatei)!= "\n" && $seek>=0)
    {
    $seek=fseek($logdatei,-2,SEEK_CUR);
    }
   if($seek<0) rewind($logdatei);
   $a=ftell($logdatei);
   }
  $zeile=fgets($logdatei);
  if(!empty($zeile))
   {
   $daten[$i]=explode('#',$zeile);
   }
  if(($richtung=='zur' && $a<2) || ($richtung=='vor' && feof($logdatei))) break;
  if($richtung=='zur') fseek($logdatei,$a-2);  // falls rueckw., setzte zeiger vor letzen zeilenumbruch
  }
 if(ftell($logdatei)==$_SESSION['log_seite'][$seite]) $daten=array();
 $_SESSION['log_seite'][$seite+1]=ftell($logdatei); // speichere zeigerposition fuer naechste seite

 echo "\n";
 // Filter in Session speichern
 for($i=0; isset($_POST['field'.$i]) && isset($_POST['operator'.$i]) && isset($_POST['value'.$i]) && $_POST['value'.$i]!=''; $i++)
  {
  $_SESSION['search_field'.$i]=$_POST['field'.$i];
  $_SESSION['search_operator'.$i]=$_POST['operator'.$i];
  $_SESSION['search_value'.$i]=$_POST['value'.$i];
  $_SESSION['search_count']=$i;
  }
 
 $found_rows=0; 
 if(!empty($daten))
  {
  // Gebe alle Daten aus
  foreach($daten as $data)
   {
   // Filter ("Suchen")
   $fertig=!$search;
   for($i=0;!$fertig && $i<=$_SESSION['search_anz'];$i++)
    {
    $feld=$_SESSION['search_field'.$i];
    if($feld=='5x')
     {
     $feld=5;
     $feld2='x';
     }
    elseif($feld=='5y')
     {
     $feld=5;
     $feld2='y';
     }
    if(isset($data[$feld]))
     {
     $wert=$_SESSION['search_value'.$i];
     if($feld==1) $wert=strtotime($wert);
     if($feld==5) $wert=str_replace(L_ANALYZE_UNKNOWN_RESOLUTION,'?',$wert);
     $operator=$_SESSION['search_operator'.$i];
     $dat=$data[$feld];
     if($feld==5)
      {
      $dat2=explode('x',$dat);
      if($feld2=='x') $dat=$dat2[0];
      else $dat=$dat2[1];
      }
     $dat=trim($dat);
     if(is_numeric($dat)) $dat+=0;

     switch($operator)
      {
      case 0:
       if(strpos($dat,$wert)===false) continue 3;
      break;
      case 1:
       if(strpos($dat,$wert)!==false) continue 3;
      break;
      case 2:
       if($dat==$wert) continue 3;
      break;
      case 5:
       if($dat!=$wert) continue 3;
      break;
      case 7:
       if($dat<=$wert) continue 3;
      break;
      case 6:
       if($dat<$wert) continue 3;
      break;
      case 3:
       if($dat>=$wert) continue 3;
      break;
      case 4:
       if($dat>$wert) continue 3;
      break;
      }
     unset($daten);
     }
    else $fertig=true;
    }
   // Ende Filter
   $found_rows++;
   // Robot?
   $is_robot=false;
   foreach($robots as $robot)
    {
    if(strpos($data[4],$robot)!==false)
     {
     $is_robot=true;
     break;
     }
    }
   aus_zeile($data,$text,$is_robot);
   }
  }
 else echo '<tr><td colspan="9">'.L_MODULEOUT_NO_DATA.'</td></tr>';
 if($search && !$text)  echo '<tr><td colspan="9">'.$found_rows.' '.L_SHOWLOG_ROWS_FOUND.'</td></tr>';
 if($text) echo '</div>';
 else echo '</tbody></table>';
 if(!$search) echo $nav;

 fclose($logdatei);
 $id_nr++;
 }

function aus_zeile($daten, $text=false,$robot=false)  // gibt Zeile aus
 {
 global $browser_anz, $browser_name, $browser_string, $system_anz, $system_name, $system_string;
 
   
 $i=0; $match=false; 
 while($i<=$browser_anz && !$match)  // teste alle Browser durch bis gefunden
  {
  if(empty($browser_name[$i])) break;
  if(strpos($daten[4],$browser_string[$i])!==false)
   {
   $browser_detected=$browser_name[$i];
   $match=true;
   }
  $i++;
  }
 if(!$match) $browser_detected=L_ANALYZE_UNKNOWN_BROWSER;
 
 $i=0; $match=false;
 while($i<=$system_anz && !$match)  // teste alle Systeme durch bis gefunden
  {
  if(empty($system_name[$i]))
   {
   break;
   }
  if(strpos($daten[4],$system_string[$i])!==false)
   {
   $system_detected=$system_name[$i];
   $match=true;
   }
  $i++;
  }
 if(!$match)  $system_detected=L_ANALYZE_UNKNOWN_SYSTEM;

 
 if(!$text) // gebe tabellenzeile aus
  {
  for($i=0; $i<=7; $i++)
   {
   if(empty($daten[$i])) $daten[$i]=" ";
   $daten[$i]=trim($daten[$i]);
   if($i==3) $daten[3]=basename(urldecode($daten[3]));
   elseif($i==6) $reflink=linkprep($daten[6]);
   elseif($i==7 && $daten[7]==32) $daten[7]=24;
   elseif($i==5 && $daten[5]=='?') $daten[5]=L_ANALYZE_UNKNOWN_RESOLUTION;
   if(strlen($daten[$i])>57 && (!$_SESSION['log_detect_agent'] || $i!=4)) $daten[$i]='<span title="'.htmlentities($daten[$i]).'">'.str_replace("'",'&#39;',htmlentities(substr($daten[$i],0,55))).'[...]</span>';
   else $daten[$i]=htmlentities($daten[$i]);
   }
  if($_SESSION['log_detect_agent']) $daten[4]="<span title='".str_replace('\'','&#39;',$daten[4])."'>".$browser_detected.'/'.$system_detected.($robot?' (bot)':'').'</span>'; 
  else $daten[4]="<span title='".str_replace('\'','&#39;',$browser_detected.'/'.$system_detected)."'>".$daten[4].'</span>'; 
  echo '<tr'.($robot?' class="robot"':'').'>';
  echo '<td>'.$daten[0].'</td><td>'.@date(L_TIME_FORMAT,$daten[1]).'</td><td>'.@date(L_DATE_FORMAT,$daten[1]).'</td><td>'.$daten[2]."</td><td title='".str_replace('\'','&#39;',$daten[3])."'>".$daten[3].'</td><td>'.$daten[4].'</td><td>'.$daten[5].'</td><td>'.(empty($daten[7])?'':$daten[7].'Bit').'</td><td>'.(empty($reflink) ? '&nbsp;' : "<a href='".$reflink."' target='_blank' class='reflinks'>".$daten[6].'</a>').'</td>';
  echo "</tr>\n";
  }
 else // gebe textzeile aus
  {
  $laengen=array(5,0,15,35,35,12,35,2);
  for($i=0; $i<=7; $i++)
   {
   if($i==1) continue;
   $s=$laengen[$i];

   if($i==3) $daten[3]=urldecode(basename($daten[3]));
   elseif($i==6) $reflink=linkprep($daten[6]);
   elseif($i==7 && $daten[7]==32) $daten[7]=24;
   elseif($i==5 && $daten[5]=='?') $daten[5]=L_ANALYZE_UNKNOWN_RESOLUTION;
   elseif($i==4)
    {
    if($_SESSION['log_detect_agent']) $daten[4]=$browser_detected.'/'.$system_detected; 
    }
   $temp=trim(substr($daten[$i],0,$s));
   for($l=strlen($temp);$l<$s;$l++) $temp.=' ';
   $daten[$i]='<span title="'.htmlentities(trim($daten[$i])).'">'.str_replace(' ','&nbsp;',str_replace("'",'&#39;',htmlentities($temp))).'</span>';
   }
  echo $daten[0].'&nbsp;|&nbsp;'.date(L_TIME_FORMAT,$daten[1]).'&nbsp;|&nbsp;'.date(L_DATE_FORMAT,$daten[1]).'&nbsp;|&nbsp;'.$daten[2].'&nbsp;|&nbsp;'.$daten[3].'&nbsp;|&nbsp;'.$daten[4].'&nbsp;|&nbsp;'.$daten[5].'&nbsp;|&nbsp;'.$daten[7].'&nbsp;|&nbsp;'.(empty($reflink) ? $daten[6] : "<a href='".$reflink."' target='_blank' class='reflinks'>".$daten[6].'</a>')."<br />\n";
  }
 }

function make_nav() // erzeugt seiten/richtungs/text-navi
 {
 global $text, $seite, $richtung;
 $aus="\n".'<form action="show_log.php"><input type="hidden" name="'.session_name().'" value="'.session_id().'" /><table style="width:100%"><tr><td style="text-align:left" class="nav"><a href="show_log.php?'.SIDX.'&amp;seite='.($seite>0?$seite-1:0).'&amp;richtung='.$richtung.($text?'&amp;text=1':'').'">'.L_SHOWLOG_PREV_PAGE.'</a></td>'
     .'<td class="nav" style="text-align:center">'.L_SHOWLOG_PAGE.' <input type="text" value="'.$seite.'" name="seite" size="4" /> <input type="submit" value="'.L_GO.'" /> | '
     .($richtung=='zur'?'<a href="show_log.php?'.SIDX.'&amp;richtung=vor'.($text?'&amp;text=1':'').'">'.L_SHOWLOG_FORWARD.'</a>':'<a href="show_log.php?'.SIDX.'&amp;richtung=zur'.($text?'&amp;text=1':'').'">'.L_SHOWLOG_BACKWARD.'</a>')
     .' | '.(!$text?'<a href="show_log.php?'.SIDX.'&amp;seite='.$seite.'&amp;richtung='.$richtung.'&amp;text=1">'.L_SHOWLOG_TEXT.'</a>':'<a href="show_log.php?'.SIDX.'&amp;seite='.$seite.'&amp;richtung='.$richtung.'">'.L_SHOWLOG_TABLE.'</a>').'</td>'
     .'<td style="text-align:right" class="nav"><a href="show_log.php?'.SIDX.'&amp;seite='.($seite+1).'&amp;richtung='.$richtung.($text?'&amp;text=1':'').'">'.L_SHOWLOG_NEXT_PAGE.'</a></td></tr></table></form>'."\n";
 return $aus;
 }
 
function finde_zeiger_pos($seite)  // findet anfangsposition zu zeile
 {
 global $logdatei, $richtung, $config_stat_log_rows;
 if($richtung=='vor') $zeile=$seite*$config_stat_log_rows;
 else $zeile=anz_zeilen()-$seite*$config_stat_log_rows;
 rewind($logdatei);
 for($i=0; $i<$zeile; $i++)
  {
  $t=fgets($logdatei);
  }
 return ftell($logdatei);
 }

function anz_zeilen()
 {
 global $logdatei;
 rewind($logdatei);
 $lines=0;
 while(!feof($logdatei))
  {
  $t=fgets($logdatei);
  $lines++;
  }
 return $lines;
 }

?>
 </body>
</html>