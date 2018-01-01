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

*** src/include.php ***
Funktion:    erzeugt (X)HTML-Code zur Einbindung
Aufrufbar:   (ja)
Eingebunden: von Ihren Dateien (include)

*/


@include_once(dirname(__FILE__).'/config_default.php');
@include_once(dirname(__FILE__).'/../usr/config.php');
@include_once(dirname(__FILE__).'/lang/'.$config_stat_lang.'.php');

// Work-around for IIS, which sometimes does not set $_SERVER['REQUEST_URI'] 
if(!isset($_SERVER['REQUEST_URI'])) {
 $_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];
 if(isset($_SERVER['QUERY_STRING'])) $_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING'];
}

if(isset($set_user) && isset($user_config[$set_user]['logfile_folder']))
 $config_logfile_folder=$user_config[$set_user]['logfile_folder'];
else $set_user=false;

if(isset($set_xhtml) && is_bool($set_xhtml)) $config_xhtml=$set_xhtml;
if(isset($set_xhtml_noscript) && is_bool($set_xhtml_noscript)) $config_xhtml_noscript=$set_xhtml_noscript;
if(isset($set_counter_enabled) && $set_counter_enabled===true)
 {
 $crazystat_add="&amp;set_counter_enabled=true";
 $config_counter_enabled=true;
 }
elseif(isset($set_counter_enabled) && $set_counter_enabled===false)
 {
 $crazystat_add="&amp;set_counter_enabled=false";
 $config_counter_enabled=false;
 }
else $crazystat_add='';
if($config_counter_enabled && ($config_counter_text || (isset($set_counter_text) && $set_counter_text))) // Textcounter
 {
 $config_counter_enabled=false;
 $crazystat_add='&amp;set_counter_enabled=false';
 $config_counter_alternative='img/blind.gif';
 $crazystat_log=file(dirname(__FILE__).'/../usr/'.$config_logfile_folder.'/'.$config_count_file);

 // Counterstand lesen (Reload?)
 if($config_counter_reload)
  {
  require_once(dirname(__FILE__).'/log_funcs.php');
  $crazystat_logfile_path=get_last_log(dirname(__FILE__).'/');
  $crazystat_logfile_handle=fopen($crazystat_logfile_path,'r');
  if($crazystat_logfile_handle===false) echo L_STAT_MSG_ERR_READ_ERROR.' F1';
  else
   {
   fseek($crazystat_logfile_handle,$crazystat_log[0]);        // Starte nicht am Anfang, sondern da, wo das letzte Mal die neuen Zugriffe begonnen haben
   $crazystat_block=time()-$config_ip_block_time*60;// Alle Zugriffe nach $block fallen unter die IP-Sperre
   $crazystat_counter_reload=false;

   while(!feof($crazystat_logfile_handle))
    {
    $crazystat_zeile=fgets($crazystat_logfile_handle);
    if(empty($crazystat_zeile)) continue;

    $crazystat_daten=explode('#',$crazystat_zeile);

    if($crazystat_daten[1]>=$crazystat_block && $crazystat_daten[2]==$_SERVER['REMOTE_ADDR'])
     {
     $crazystat_counter_reload=true;
     break;  // Reload wurde erkannt
     }
    }
   fclose($crazystat_logfile_handle);
   $crazystat_anzahl_hits_ip=trim($crazystat_log[1]);
   if(!$crazystat_counter_reload) $crazystat_anzahl_hits_ip++;
   }
  }
 else $crazystat_anzahl_hits=trim($crazystat_log[2])+1;
 $counter_value=($config_counter_reload?$crazystat_anzahl_hits_ip:$crazystat_anzahl_hits)+$config_counter_add;
 $counter_stand=$counter_value; // backwards-compatibility with 1.6x
 // Ende Counterstand lesen
 }

if(isset($set_rel_pfad) && !isset($set_rel_path)) $set_rel_path=$set_rel_pfad; // backwards-compatibility for CrazyStat < 1.70
if($config_different_rel_paths && isset($set_rel_path)) $config_rel_path=$set_rel_path;
elseif(!isset($config_rel_path) && is_dir('stat/')) $config_rel_path='stat/'; // falls config nicht korrekt eingebunden, wird standard-wert ueberprueft

if(isset($set_counter_datei_name) && !isset($set_counter_file_name)) $set_counter_file_name=$set_counter_datei_name; // backwards-compatibility for CrazyStat < 1.70
if(isset($set_counter_file_name) && is_file(dirname(__FILE__).'/../usr/'.$config_counter_folder.'/'.$set_counter_file_name))
 {
 $crazystat_add.='&amp;set_counter_file_name='.urlencode($set_counter_file_name);
 $config_counter_file_name=$set_counter_file_name;
 }
if(isset($config_counter_link) && $config_counter_link!=false)
 {
 $config_counter_link=str_replace("%CRAZYSTATPATH%",$config_rel_path,$config_counter_link);
 $crazystat_link='<a href="'.$config_counter_link.'"'.($config_counter_link_target===false?'':' target="'.$config_counter_link_target.'"').'>';
 }
else $crazystat_link='';

$crazystat_zeit=time();
echo base64_decode('PCEtLSBCRUdJTiBDcmF6eVN0YXQgMS43').'0';
echo base64_decode('IENvcHlyaWdodCAoQykgMjAwNC0yMDE=').'1';
echo base64_decode('IENocmlzdG9waGVyIEsuIGh0dHA6Ly93d3cuY2hyaXN0b3NvZnQuZGUgLy0tPg0KPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPg==');

if($config_counter_enabled)
 {
 if(is_file(dirname(__FILE__).'/../usr/'.$config_counter_folder.'/'.$config_counter_file_name))
  $crazystat_groesse=getimagesize(dirname(__FILE__).'/../usr/'.$config_counter_folder.'/'.$config_counter_file_name);
 else
  $crazystat_groesse=getimagesize(($config_rel_path[0]=='/'?'.':'').$config_rel_path.$config_counter_folder.'/'.$config_counter_file_name);
 $crazystat_breite=round($crazystat_groesse[0]/10)*$config_counter_digits;
 }
else
 {
 if($config_counter_alternative===false) // blank 1x1 gif without redirection
  $crazystat_groesse=array(1,1);
 elseif(is_file(dirname(__FILE__).'/'.$config_counter_alternative))
  $crazystat_groesse=getimagesize(dirname(__FILE__).'/'.$config_counter_alternative);
 else
  $crazystat_groesse=getimagesize(($config_rel_path[0]=='/'?'.':'').$config_rel_path.$config_counter_alternative);
 $crazystat_breite=$crazystat_groesse[0];
 }
$crazystat_hoehe=$crazystat_groesse[1];
$crazystat_c=base64_decode('IC0gLSAtIEJ5IENyYXp5U3RhdCAtIC0gLSA=');

if($config_xhtml)
 {
 $crazystat_attribute='alt="'.$config_alt_text.$crazystat_c.'" title="'.$config_alt_text.$crazystat_c.'"  style="border:0px"'.($crazystat_hoehe>0?' height="'.$crazystat_hoehe:'').'"';
?>
/* <![CDATA[ */
function CrazyStat()
 {
 if (typeof(crazystat_oldOnLoad)=='function') crazystat_oldOnLoad();
 var jetzt=new Date();
 var CrazyStatUrl='<?php echo $config_rel_path; ?>src/stat.php?<?php if($set_user) echo 'user='.$set_user.'&'; ?>breite='+screen.width+'&hoehe='+screen.height+'&colors='+screen.colorDepth+'&datei=<?php echo urlencode($_SERVER['REQUEST_URI']).'&referer='.urlencode(getenv('HTTP_REFERER')).str_replace('&amp;','&',$crazystat_add); ?>&t='+jetzt.getTime();
 if(document.getElementById) var obj=document.getElementById('CrazyStatImage'); else if(document.all) var obj=document.all('CrazyStatImage');
 if(obj) { obj.src=CrazyStatUrl; obj.width=<?php echo $crazystat_breite; ?>; }
 }
var crazystat_oldOnLoad=window.onload;
window.onload=CrazyStat;
/* ]]> */
</script>
<?php echo $crazystat_link; ?><img id="CrazyStatImage" src="<?php echo $config_rel_path; ?>src/img/blind.gif" <?php echo $crazystat_attribute; ?> width="1" /><?php if(!empty($crazystat_link)) echo '</a>';
if($config_xhtml_noscript) { ?>
<noscript><?php echo $crazystat_link; ?><img src="<?php echo $config_rel_path; ?>stat.php?datei=<?php echo urlencode($_SERVER["REQUEST_URI"])."&amp;referer=".urlencode(getenv("HTTP_REFERER")).$crazystat_add.'&amp;t='.$crazystat_zeit; ?>" <?php echo $crazystat_attribute.' width="'.$crazystat_breite.'"'; ?> /><?php if(!empty($crazystat_link)) echo '</a>'; ?></noscript>
<?php
 } }
else
 {
?>
//<!--
var jetzt=new Date();
document.write ('<?php echo $crazystat_link; ?><img src=\"<?php echo $config_rel_path; ?>src/stat.php?<?php if($set_user) echo 'user='.$set_user.'&'; ?>breite='+screen.width+'&amp;hoehe='+screen.height+'&amp;colors='+screen.colorDepth+'&amp;datei=<?php echo urlencode($_SERVER["REQUEST_URI"])."&amp;referer=".urlencode(getenv("HTTP_REFERER")).$crazystat_add.'&amp;t='; ?>'+jetzt.getTime()+'\" alt=\"<?php echo $config_alt_text.$crazystat_c; ?>\" title=\"<?php echo $config_alt_text.$crazystat_c; ?>\"<?php echo ($crazystat_breite>0?' width="'.$crazystat_breite.'"':'').($crazystat_hoehe>0?' height="'.$crazystat_hoehe.'"':''); ?> style="border: 0;" /><?php if(!empty($crazystat_link)) echo '<\/a>'; ?>');
//-->
</script>
<noscript><div><?php echo $crazystat_link; ?><img src="<?php echo $config_rel_path; ?>src/stat.php?datei=<?php echo urlencode($_SERVER["REQUEST_URI"])."&amp;referer=".urlencode(getenv("HTTP_REFERER")).$crazystat_add; ?>" alt="<?php echo $config_alt_text.$crazystat_c; ?>" title="<?php echo $config_alt_text.$crazystat_c; ?>"<?php echo ($crazystat_breite>0?' width="'.$crazystat_breite.'"':'').($crazystat_hoehe>0?' height="'.$crazystat_hoehe.'"':''); ?> style="border:0;"<?php echo ($config_xhtml_old?' /':''); ?>><?php if(!empty($crazystat_link)) echo '</a>'; ?></div></noscript><?php } echo "\n".base64_decode('PCEtLSBFTkQgQ3JhenlTdGF0IC8tLT4=')."\n"; ?>