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

*** src/index.php ***
Funktion:    Eingangsseite, News, verbirgt Verzeichnisstruktur
Aufrufbar:   ja
Eingebunden: nein/ von src/include.php (Link)
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

$christosoft_url='http://'.($config_stat_lang=='de'?'www':'en').'.christosoft.de';


header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="generator" content="CrazyStat" />
  <title>CrazyStat 1.70</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href="style2.css" rel="stylesheet" type="text/css" />
 </head>
 <body>
  <div align="center">
   <div id="outer_main">
    <h1 style="font-size:24pt;"><img src="img/crazystat.gif" alt="CrazyStat" title="" width="146" height="35" /></h1>
    <div id="panel"><div class="reiter" id="r0_1"><?php echo L_LOGIN_MENU_HOME; ?></div><div class="reiter" id="r1_0" style="border-left: 1px solid black"><a href="show_stat.php"><?php echo L_LOGIN_MENU_LOGIN; ?></a></div><div class="reiter" id="r2_0"><a href="show_stat.php?change_pass"><?php echo L_LOGIN_MENU_CHANGE_PASSWORD; ?></a></div></div>
    <div id="inner_main" align="center">
     <h2><?php echo L_INDEX_WELCOME; ?></h2>
     <p><?php echo L_INDEX_THIS_IS_CRAZYSTAT; ?></p>
     <p><?php echo L_INDEX_INFORMATION; ?><br />
     <a href="<?php echo $christosoft_url; ?>" target="_blank"><?php echo $christosoft_url; ?></a></p>
     <table class="gitter">
      <tr><td><?php echo L_INDEX_INSTALLED_VERSION; ?></td><td style="vertical-align:top"><?php echo L_INDEX_CURRENT_VERSION; ?></td></tr>
      <tr><td width="200">1.70</td><td style="vertical-align:top; padding:0px; margin:0px;"><iframe src="http://www.christosoft.de/crazystat_version.php?v=170" frameborder="0" height="60" width="200"></iframe></td></tr>
     </table>
     <p>
      <?php echo L_INDEX_NEWS; ?> <a href="<?php echo $christosoft_url; ?>" target="_blank"><?php echo $christosoft_url; ?></a>:<br />
      <iframe src="http://www.christosoft.de/news.php?v=170&amp;lang=<?php echo $config_stat_lang; ?>" frameborder="0" height="200" width="550"></iframe>
     </p>
    </div>
   </div>
   <p class="copyright">&copy; Copyright 2004-2011 <a href="<?php echo $christosoft_url; ?>" target="_blank">Christopher Kramer</a></p>
  </div>
 </body>
</html>