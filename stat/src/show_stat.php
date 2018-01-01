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

*** src/show_stat.php ***
Funktion:    gibt ausgewertete Logdatei aus
Aufrufbar:   ja
Eingebunden: von src/index.php (Link)
*/

if(false) {
?>
<h1>Attention!</h1>
<p style="color: red; font-weight: bold;">
The php code is not beeing parsed but sent to the browser.<br />
CrazyStat can only run on a webserver (like Apache) with PHP installed and configured!
It does <u>not</u> run on normal PCs (without a webserver) and <u>not</u> on webservers without PHP.<br />
If you installed CrazyStat on a webserver with php, it is not correctly configured
(.php-files have to be parsed by php) or CrazyStat was started incorrectly.<br />
If you want to run CrazyStat locally and have a webserver with php installed,
put CrazyStat in the home-directory of your webserver (e.g. htdocs/stat or
wwwroot/stat) and open http://localhost/stat/show_stat.php in your browser
(<u>not</u> C:\Program Files\Apache\htdocs\stat\show_stat.php or similar).
</p>
<h1>Achtung!</h1>
<p style="color: red; font-weight: bold;">
Der PHP-Code wird nicht ausgeführt sondern an den Browser gesendet.<br />
CrazyStat kann nur auf einem Webserver (z.B. Apache) mit installiertem PHP ausgeführt werden!
<u>Nicht</u> auf normalen PCs (ohne Webserver) und <u>nicht</u> auf Webservern ohne PHP.<br />
Wenn CrazyStat auf einem Webserver mit PHP liegt, ist dieser entweder nicht richtig konfiguriert
(.php-Dateien müssen von PHP geparsed werden) oder CrazyStat wurde falsch aufgerufen.<br />
Wenn Sie CrazyStat lokal auf einem PC mit installierten Webserver und PHP ausführen möchten,
legen Sie CrazyStat unterhalb des Hauptverzeichnisses des Webservers (z.B. htdocs/stat oder
wwwroot/stat) und rufen es über http://localhost/stat/show_stat.php (<u>nicht</u> C:\Programme\Apache\htdocs\stat\show_stat.php o.ä.) auf.
</p><!--
<?php
}

// Initialize message-texts
$meldung_ok='';
$meldung_fehler='';
$meldung_fatal='';

require_once('general_include.php');
require_once('module_out.php');
require_once('preset.php');
 
// Ajax?
if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']) $_SESSION['ajax']=true;

// Set all modules as "not changed" (for caching)
foreach($list_modules as $module) $changed[$module]=false;

// Initialize settings (no overwrite!)
preset($config_stat_default_preset,false);

// If a preset was selected, load the settings of this preset
if(isset($_POST['Preset_Auswahl']))  preset($_POST['Preset_Auswahl']);

// Settings for the tree-extension
if(isset($_GET['tree']))
 {
 switch($_GET['tree'])
  {
  case 'mk': $_SESSION['tree']='mk'; break;
  case 'ajax': $_SESSION['tree']='ajax'; break;
  case '0': $_SESSION['tree']=false; break;
  }
 }
if($_SESSION['tree']=='ajax' && !is_file('extensions/ajaxTree/ajaxTree.js')) $_SESSION['tree']=false;

header('Content-Type: text/html; charset=UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";              
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>CrazyStat</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" language="javascript">
  //<![CDATA[
   var waitbox = false;
   var wait_timer;
   var sid = '<?php echo SIDX; ?>';
   function waitmessage()
    {
    if(wait_timer) clearTimeout(wait_timer);
    wait_timer=setTimeout('waitmessage2()',500);
    }
   function waitmessage2()
    {
    document.getElementById('messagebox_title').innerHTML='<?php echo L_PLEASE_WAIT; ?>';
    document.getElementById('messagebox_text').innerHTML='<p><?php echo L_SHOWSTAT_MSG_OK_WAIT; ?><\/p><p><img src="img/wait.gif" alt="" style="margin-right:10px;" \/><?php echo L_PLEASE_WAIT; ?><\/p>';
    document.getElementById('messagebox').style.display='block';
    document.getElementById('body').style.cursor='wait';
    waitbox = true;  
    document.getElementById("startOverlay").style.display="block";  
    }
   function messagebox(text)
    {
    hide_waitbox();
    document.getElementById('messagebox_title').innerHTML='CrazyStat';
    document.getElementById('messagebox_text').innerHTML=text;
    document.getElementById('messagebox').style.display='block';
    document.getElementById("startOverlay").style.display="block";  
    }
   function hide_messagebox()
    {
    if(wait_timer) clearTimeout(wait_timer);
    document.getElementById('messagebox').style.display='none';
    document.getElementById("startOverlay").style.display="none";
    if(waitbox)
     {
     document.getElementById('body').style.cursor='auto';
     }  
    }
   function hide_waitbox()
    {
    if(wait_timer) clearTimeout(wait_timer);
    document.getElementById("startOverlay").style.display="none";  
    if(waitbox)
     {
     document.getElementById('messagebox').style.display='none';
     document.getElementById('body').style.cursor='auto';
     waitbox = false;
     }
    }
   function preset_select(select_element)
    {
    var selected_value=select_element.form.Preset_Auswahl.options[select_element.form.Preset_Auswahl.selectedIndex].value;
    if(selected_value!='Presets' && selected_value!='Manage')
     {
     waitmessage();
     select_element.form.submit();
     }
    if(selected_value=='Manage')
     {
     <?php if($config_stat_ext_lytebox) { ?>
     var myLink = document.createElement('a');
     myLink.href='preset_editor.php?'+sid;
     myLink.rel='lyteframe';
     myLink.rev='width: 600px; height: 500px;';
     myLytebox.start(myLink,false,true);
     <?php } else echo 'var presets=window.open("preset_editor.php"+sid,"preset_editor","width=600,height=500, scrollbars=yes"); presets.focus();'; ?>
     select_element.form.Preset_Auswahl.selectedIndex=0;
     }   
    }        
   var use_ajax = <?php echo ($config_stat_ajax?'true':'false'); ?>;
   <?php if($config_stat_overlay) { ?>
   var oldOnLoad=window.onload;
   window.onload= function() {
     if (typeof(oldOnLoad)=='function') oldOnLoad();
     document.getElementById("startOverlay").style.display="none";
   };
  //]]>
  <?php } ?>
  </script>
  <script type="text/javascript" src="ajax.js"></script>
  <script type="text/javascript" src="module_refresh.js"></script>
<?php if(is_file('extensions/sortabletable.js')) { ?>
  <script type="text/javascript" src="extensions/sortabletable.js"></script>
  <script type="text/javascript">var sortabletable=true;</script>
<?php } if(is_file('extensions/mktree.css') && is_file('extensions/mktree.js')) { ?>
  <link href="extensions/mktree.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="extensions/mktree.js"></script>
<?php }
if(is_file('extensions/ajaxTree/ajaxTree.js') && is_file('extensions/ajaxTree/ajaxTree.css')) { ?>
  <link href="extensions/ajaxTree/ajaxTree.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="extensions/ajaxTree/ajaxTree.js"></script>
  <script type="text/javascript" src="extensions/json2.js"></script>  
<?php } if($config_stat_ext_lytebox && is_file('extensions/lytebox.js') && is_file('extensions/lytebox.css')) { ?>
  <script type="text/javascript" language="javascript" src="extensions/lytebox.js"></script>
  <link rel="stylesheet" href="extensions/lytebox.css" type="text/css" media="screen" />
<?php } ?>
  <meta name="generator" content="CrazyStat 1.70" />
  <meta http-equiv="expires" content="0" />
  <style type="text/css">
  .max {
  <?php echo $config_stat_max_style;?>
  }
  </style>
 </head>
 <body id="body" style="padding-left:0px;">
  <?php if($config_stat_overlay) { ?>
  <script type="text/javascript">
  // as this is hidden via JS, it must not be shown if no JS is available
  //<![CDATA[
  document.write('<div id="startOverlay" style="height: 10000px; width:100%; opacity: 0.75; filter:Alpha(opacity=75, finishopacity=75, style=2); position: absolute; top: 0; left:0; z-index: 99996; background-color: #000000; display: block" onClick="hide_messagebox();"><\/div>');
  //]]>
  </script>
  <?php } ?>
  <h1 style="margin-left:4px"><img src="img/crazystat.gif" alt="CrazyStat" title="" width="146" height="35" /></h1>
  <div class="menue">
   <form method="post" action="show_stat.php">
    <input type="hidden" name="<?php echo htmlspecialchars(session_name()); ?>" value="<?php echo htmlspecialchars(session_id()); ?>" />
    <select class="presets" name="Preset_Auswahl" size="1" onchange="preset_select(this)">
     <option class="presetsHead" value="Presets"> &gt;&gt; <?php echo L_SHOWSTAT_PRESETS; ?> &lt;&lt; </option>
     <?php
     foreach($config_preset as $preset_id => $preset_data)
      {
      if(isset($preset_data['name'])) echo      '<option value="'.$preset_id.'">'.$preset_data['name'].'</option>';
      } 
     ?>
     <option value="Manage">( <?php echo L_SHOWSTAT_PRESETS_MANAGE; ?> )</option>
    </select>
    <noscript>
     <input id="preset_go" type="submit" value="<?php echo L_GO; ?>" />
     <a href="preset_editor.php?<?php echo SIDX; ?>"><img src="img/settings.png" alt="<?php echo L_SHOWSTAT_PRESETS_MANAGE; ?>" title="<?php echo L_SHOWSTAT_PRESETS_MANAGE; ?>" /></a>
    </noscript>
<?php if($config_stat_preset_file_cache) { ?>
    <a href="show_stat.php?<?php echo SIDX; ?>&amp;clearcache=true&amp;reload=true" onclick="waitmessage();"><img src="img/cache_clear.png" alt="<?php echo L_SHOWSTAT_CLEAR_CACHE; ?>" title="<?php echo L_SHOWSTAT_CLEAR_CACHE; ?>" /></a>
<?php } ?>
    <a href="about.php" target="_blank" rel="lyteframe" rev="width: 420px; height: 380px; scrolling: no;"><img src="img/about.png" alt="<?php echo L_MENU_ABOUT; ?>" title="<?php echo L_MENU_ABOUT; ?>" /></a>
    <a href="anonymous_redirect.php?go_anonym=<?php echo 'http://'.($config_stat_lang=='de'?'www':'en').'.christosoft.de'; ?>" target="_blank"><img src="img/website.png" alt="<?php echo L_MENU_WEBSITE; ?>" title="<?php echo L_MENU_WEBSITE; ?>" /></a>
<?php if($config_stat_cache) { 
// onclick="refresh('ALL','mode=refresh'); return false;"
?>
    <a href="show_stat.php?<?php echo SIDX; ?>&amp;reload=true" onclick="waitmessage();"><img src="img/refresh.png" alt="<?php echo L_SHOWSTAT_REFRESH_ALL; ?>" title="<?php echo L_SHOWSTAT_REFRESH_ALL; ?>" /></a>
<?php } ?>
    <a href="logs.php?<?php echo SIDX; ?>"><img src="img/logs.png" alt="<?php echo L_SHOWSTAT_LOGS; ?>" title="<?php echo L_SHOWSTAT_LOGS; ?>" /></a>
<?php if($config_stat_password_protect) { ?>
    <a href="show_stat.php?<?php echo SIDX; ?>&amp;logout=true"><img src="img/logout.png" alt="<?php echo L_LOGOUT; ?>" title="<?php echo L_LOGOUT; ?>" /></a>
<?php } ?>
   </form>
  </div>

<?php


// Lesen der Diagramm-Einstellungen

foreach($list_modules_diagram as $modul)
 {
 if(isset($_GET['diagramm_'.$modul]))
  {
  if($_GET['diagramm_'.$modul]=='1') $_SESSION['set_'.$modul.'_piechart']=true;
  else $_SESSION['set_'.$modul.'_piechart']=false;
  }
 }

// Lesen der Limit Einstellungen
foreach($list_modules_limit as $modul)
 {
 if(isset($_GET[$modul.'_all']) && $_GET[$modul.'_all']==1) $_SESSION['set_'.$modul.'_all']=true;
 elseif(isset($_GET[$modul.'_all'])) $_SESSION['set_'.$modul.'_all']=false;
 }

// Lesen der IP-Einstellungen
foreach($list_modules as $modul)
 {
 if(isset($_GET['ip_'.$modul]))
  {
  if($_SESSION['set_'.$modul.'_ip']!=$_GET['ip_'.$modul]) $changed[$modul]=true;
  if($_GET['ip_'.$modul]==0) $_SESSION['set_'.$modul.'_ip']=false;
  else $_SESSION['set_'.$modul.'_ip']=true;
  }
 }

// Von calendar.php uebergebene oder durch "aktualisieren"-Button ausgeloeste changed-daten auslesen
if(isset($_GET['changed']) && isset($modul[$_GET['changed']])) $changed[$_GET['changed']]=true;


require_once('analyze.php');

// Meldungen ausgeben
if(!empty($meldung_ok) || !empty($meldung_fehler) || !empty($meldung_fatal))
 {
 ?>
 <script type="text/javascript">
 //<![CDATA[
 function message()
  {
  if (typeof(oldOnLoad2)=='function') oldOnLoad2();
  oldOnLoad2=null;
  messagebox('<?php
     if(!empty($meldung_fatal)) echo '<p class="meldung_fehler">'.str_replace("\n",'<br />',$meldung_fatal).'<\/p>';
     if(!empty($meldung_fehler)) echo '<p class="meldung_fehler">'.str_replace("\n",'<br />',$meldung_fehler).'<\/p>';
     if(!empty($meldung_ok)) echo '<p class="meldung_ok">'.str_replace("\n",'<br />',$meldung_ok).'<\/p>';   ?>');
  }
 var oldOnLoad2=window.onload;
 window.onload=message;
 //]]>
 </script>
 <noscript>
  <?php
  if(!empty($meldung_fatal)) echo '<p class="meldung_fehler">'.$meldung_fatal.'</p>';
  if(!empty($meldung_fehler)) echo '<p class="meldung_fehler">'.$meldung_fehler.'</p>';
  if(!empty($meldung_ok)) echo '<p class="meldung_ok">'.$meldung_ok.'</p>';
  ?>
 </noscript>
 <?php
 }

if(empty($meldung_fatal))
 {
 // Ausgeben der Ergebnisse
 ?>
 <!-- Start Module-->
 <table width="100%">
  <tr>
   <td class="spalte">
 <?php

 // Hit
 module_out('hit');
 
 // weekday
 module_out('weekday');
 
 // month
 module_out('month');
 echo '  </td>'."\n".'  <td class="spalte" style="width:16%">'."\n";
 
 // day
 module_out('day');
 echo '  </td>'."\n".'  <td class="spalte">'."\n";
 
 // hour
 module_out('hour');
 
 // Browser
 module_out('browser');
 echo '  </td>'."\n".'  <td class="spalte" style="width:31%">'."\n";
 
 // file
 module_out('file');
 
 // resolution
 module_out('resolution');
 
 // colordepth
 module_out('colordepth');
 
 // System
 module_out('system');
 ?>
   </td>
  </tr>
  <tr>
   <td colspan="3" style="vertical-align:top;">
 <?php
 // Referer
 module_out('referer');
 ?>
   </td>
   <td class="spalte">
 <?php
 // Keyword
 module_out('keyword');
 ?>
   </td>
  </tr>
 </table>
 <!-- Ende Module-->
 <?php
 }
 
if($_SESSION['debug'] && (!empty($_SESSION['unknown_browser'])  || !empty($_SESSION['unknown_system'])))
 {
 echo '<table><tr><td colspan="2"><b>'.L_MODULES_BROWSER_P.'</b></td></tr>';
 if(!empty($_SESSION['unknown_browser']))
  {
  foreach($_SESSION['unknown_browser'] as $browser=>$anz)
   {
   echo "<tr><td>".strip_tags($browser)."</td><td>".$anz."</td></tr>";
   }
  }
 echo '<tr><td colspan="2"><b>'.L_MODULES_SYSTEM_P.'</b></td></tr>';
 if(!empty($_SESSION['unknown_system']))
  {
  foreach($_SESSION['unknown_system'] as $system=>$anz)
   {
   echo "<tr><td>".strip_tags($system)."</td><td>".$anz."</td></tr>";
   }
  }
 echo "</table>";
 }
 ?>
<!-- Start Messagebox -->
<div id="messagebox">
 <table style="width:100%; text-align:center">
  <tr><th class="modul"><span id="messagebox_title"><?php echo L_PLEASE_WAIT; ?></span></th></tr>
  <tr>
   <td id="messagebox_text">
    <p><?php echo L_SHOWSTAT_MSG_OK_WAIT; ?></p>
    <p><img src="img/wait.gif" alt="" style="margin-right:10px;" /><?php echo L_PLEASE_WAIT; ?></p>
   </td>
  </tr>
 </table>
 <div id="messagebox_close"><a href="nojs.php" onclick="hide_messagebox(); return false;"><img src="img/close.png" alt="<?php echo L_CLOSE; ?>" /></a></div>
</div>
<!-- End Messagebox -->

 </body>
</html>
