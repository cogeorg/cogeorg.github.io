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

*** src/about.php ***
Function:                       show some general info about CrazyStat
Meant to be opned in browser:   yes
Included:                       by show_stat.php, show_log.php, logs.php,
                                log_search.php  (lyteframe/Link)
*/

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
 <title>CrazyStat</title>
 <meta name="generator" content="CrazyStat" />
 <meta http-equiv="expires" content="0" />
 <link href="style.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
 * {
 text-align: center;
 }
 
 table.gitter td {
 border: 1px solid #888888;
 padding: 3px;
 text-align: center;
 }

 table.gitter {
 border-collapse:collapse;
 margin: 0 auto;
 }
 </style>
</head>
<body>
<img src="img/crazystat.gif" alt="CrazyStat" />
<p><?php echo L_INDEX_THIS_IS_CRAZYSTAT; ?></p>
<table class="gitter">
 <tr><td><?php echo L_INDEX_INSTALLED_VERSION; ?></td><td style="vertical-align:top"><?php echo L_INDEX_CURRENT_VERSION; ?></td></tr>
 <tr><td width="150">1.70</td><td style="vertical-align:top; padding:0px; margin:0px;"><iframe src="http://www.christosoft.de/crazystat_version.php?v=170&amp;about=1" frameborder="0" height="40" width="150" scrolling="no"></iframe></td></tr>
</table>
<p><?php echo L_ABOUT_PLEASE_SEE; ?> <a href="../doc/README_<?php echo $config_stat_lang; ?>.html" target="_blank"><?php echo L_ABOUT_README; ?></a> <?php echo L_AND; ?> <a href="../doc/faq_<?php echo $config_stat_lang; ?>.html" target="_blank"><?php echo L_ABOUT_FAQ; ?></a> <?php echo L_ABOUT_FOR_HELP; ?></p>
<p>Copyright 2004 - 2011 Christopher Kramer<br />

<a href="anonymous_redirect.php?go_anonym=<?php echo $christosoft_url; ?>" target="_blank"><?php echo $christosoft_url; ?></a></p>

<?php

if($config_stat_lang=='de')
 {
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="donate">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="AFXFF7MLDDBZS">
<input type="image" src="https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
<?php
 }
else
 {
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="2ATCZHWMNRX34">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
<?php
 }
?>
</body>
</html>