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

*** anonymous_redirect.php ***
Function:                        Anonymously redirects to given URL
Meant to be opened in browser:   no
Included:                        by 
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

if(isset($_GET['go_anonym']))
 {
 $_GET['go_anonym']=htmlentities(strip_tags(str_replace('%26', '&',$_GET['go_anonym'])));

header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title><?php echo L_ANONYMOUS_REDIRECT.' '.$_GET['go_anonym']; ?></title>
  <meta http-equiv="refresh" content="1; URL=<?php echo $_GET['go_anonym']; ?>">
 </head>
 <body>
  <p><?php echo L_ANONYMOUS_REDIRECT; ?> <a href="<?php echo $_GET['go_anonym']; ?>"><?php echo $_GET['go_anonym']; ?></a></p>
  <p><?php echo L_PLEASE_WAIT; ?></p>
 </body>
</html>
 <?php
 exit;
 }

?>