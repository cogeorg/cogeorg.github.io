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

*** general_include.php ***
Function:                        Loads includes, user settings, offers module-arrays and general functions
Meant to be opened in browser:   no
Included:                        by
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
require_once('log_funcs.php');
require_once('password_protect.php');

// set Session-ID-constant (XSS-resistant)
define('SIDX',htmlspecialchars(SID));


// User_config

if(isset($_SESSION['username']) && is_array($user_config[$_SESSION['username']]))
 {
 foreach($user_config[$_SESSION['username']] as $user_setting => $user_value)
  {
  $user_setting='config_'.$user_setting;
  $$user_setting=$user_value;
  }
 }



// Arrays which contain all modules (of a certain type)
$list_modules=Array('hit','weekday','month','day','hour','browser','file','resolution','colordepth','system','referer','keyword');
$list_modules_limit=Array('browser','file','resolution','colordepth','system','referer','keyword');
$list_modules_diagram=Array('browser','resolution','system');
$list_modules_calendar=Array('weekday','month','day','hour','browser','file','resolution','colordepth','system','referer','keyword');

function parse_str_to_time($str)
 {
 return strtotime(time_replace_chars($str));
 }
 
function time_replace_chars($str)
 {
 foreach(array('d','m','Y','H','i','s','D','l','W','w','F') as $char) $str=str_replace('%'.$char,date($char),$str);
 return $str;
 }
 
function calc_start_id($str)
 {
 if(strpos($str,'-')!==false) $op='-';
 elseif(strpos($str,'+')!==false) $op='+';
 else return time_replace_chars($str);
 $parts=explode($op,$str);
 $result=0;
 $opuse=false;
 foreach($parts as $id=>$part)
  {
  $part=time_replace_chars($part);
  $result+=(($op=='-' && $opuse)?-1:1)*$part;
  $opuse=true;
  }
 return $result;
 }

function linkprep ($p_url) {
// Diese Funktion kodiert eine URL so, dass sie in <a href=''> eingesetzt werden kann, der Link funktioniert aber das HTML valide bleibt.
// Achtung: nicht XSS-Sicher wenn die URL in <a href=""> eingefügt wird!

// vielen dank an dphantom at ticino dot com für diese Funktion (veröffentlicht unter http://www.php.net/manual/de/function.rawurlencode.php)
// die Funktion wurde leicht angepasst, um notice-fehlermeldungen zu unterdruecken
     $ta = parse_url($p_url);
     if (!empty($ta['scheme'])) { @$ta['scheme'].='://'; }
     if (!empty($ta['pass']) and !empty($ta['user'])) {
             @$ta['user'].=':';
             @$ta['pass']=rawurlencode($ta['pass']).'@';
     } elseif (!empty($ta['user'])) {
         @$ta['user'].='@';
     }
     if (!empty($ta['port']) and !empty($ta['host'])) {
         @$ta['host']=''.$ta['host'].':';
     } elseif    (!empty($ta['host'])) {
         @$ta['host']=$ta['host'];
     }
     if (!empty($ta['path'])) {
         $tu='';
         $tok=strtok($ta['path'], "\\/");
         while (strlen($tok)) {
             @$tu.=rawurlencode($tok).'/';
             $tok=strtok("\\/");
         }

         @$ta['path']='/'.($ta['path'][strlen($ta['path'])-1]=='/'?ltrim($tu, '/'):trim($tu, '/'));
     }
     if (!empty($ta['query'])) { $ta['query']='?'.$ta['query']; }
     if (!empty($ta['fragment'])) { $ta['fragment']='#'.$ta['fragment']; }
     return str_replace('\'','&#39;',stripslashes('anonymous_redirect.php?go_anonym='.str_replace('&','%26',@implode('', array($ta['scheme'], $ta['user'], $ta['pass'], $ta['host'], $ta['port'], $ta['path'], $ta['query'], $ta['fragment'])))));
 }


?>