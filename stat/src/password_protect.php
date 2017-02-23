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

*** src/password_protect.php ***
Funktion:    überprüft Passwort und Username, Loginformular, logout, Passwort ändern
Aufrufbar:   (ja)
Eingebunden: von allen sicherheitskritischen Modulen (require/include), z.B. src/show_stat.php, src/show_log.php etc.
*/

@session_start();

if(isset($_GET['logout']))
 {
 session_destroy();
 unset($_SESSION['username']);
 unset($_SESSION['passwort']);
 session_start();
 }
 
require_once(dirname(__FILE__).'/config_default.php');
require_once(dirname(__FILE__).'/../usr/config.php');
require_once(dirname(__FILE__).'/lang/'.$config_stat_lang.'.php');
require_once(dirname(__FILE__).'/../usr/config_pass.php');

// when installed freshly, initialize config_pass.php (set salt)
if($config_salt_str=='SomeRand0m_strlng' && isset($config_stat_user['admin']) && $config_stat_user['admin']=='d4c5bfbe9a9ed1d9b117eec7c7f85179')
 {
 $config_salt_str=md5(mt_rand());
 $config_stat_user['admin']=md5('pass'.$config_salt_str); // recalc default admin-PW with new salt
 @$pass_file=fopen(dirname(__FILE__).'/../usr/config_pass.php','w');
 if($pass_file===false)
  {
  session_destroy();
  $meldung_fehler.=L_PASSWORD_MES_ERR_WRITING_FAILED.'<br /><a href="show_stat.php?logout=1&change_pass=1">'.L_PASSWORD_MES_ERR_RETRY.'</a>';
  }
 else
  {
  fwrite($pass_file,'<?php $config_salt_str='.var_export($config_salt_str,true).'; $config_stat_user='.var_export($config_stat_user,true).'; ?>'); //<?php
  fclose($pass_file);
  }
 }

if(!isset($_SESSION['cookie'])) $_SESSION['cookie']=false;

// fallback for old configuration-files
if(!is_array($config_stat_user) && isset($config_stat_passwort) && isset($config_stat_username))  $config_stat_user[$config_stat_username]=$config_stat_passwort;

if($config_stat_password_md5 && isset($_POST['passwort'])) // password saved as hash
 {
 if(!empty($_POST['md5'])) $_POST['passwort']=$_POST['md5'];  // already got an MD5 hash from the client (using JS)
 else $_POST['passwort']=md5(md5($_POST['passwort'].$config_salt_str).$_SESSION['login_rand']); // plain password sent by client
 }
elseif(!$config_stat_password_md5 && !empty($_POST['md5']) && isset($_POST['username']) && isset($config_stat_user[$_POST['username']]))  // password not saved as hash, but client sent hash
 {
 $config_stat_user[$_POST['username']]=md5($config_stat_user[$_POST['username']].$config_salt_str); // claculate hash of saved password
 $_POST['passwort']=$_POST['md5'];
 $_SESSION['md5']=true;
 }
elseif(isset($_SESSION['md5']) && $_SESSION['md5'] && isset($_SESSION['username']))
 {
 $config_stat_user[$_SESSION['username']]=md5($config_stat_user[$_SESSION['username']].$config_salt_str); // calculate hash of saved password
 }

if(($config_stat_password_protect==true && isset($_POST['passwort']) && isset($_POST['username']) && isset($config_stat_user[$_POST['username']]) && isset($_SESSION['login_rand']) && $_POST['passwort']==md5($config_stat_user[$_POST['username']].$_SESSION['login_rand'])) || (isset($_SESSION['username']) && isset($_SESSION['passwort']) && isset($config_stat_user[$_SESSION['username']]) && $_SESSION['passwort']==$config_stat_user[$_SESSION['username']]) || $config_stat_password_protect===false)
 {
 @$_SESSION['username']=(isset($_POST['username'])?$_POST['username']:$_SESSION['username']);
 @$_SESSION['passwort']=$config_stat_user[$_SESSION['username']];
 unset($_SESSION['login_rand']);
 if(isset($_POST['sperre_pc']) && $_POST['sperre_pc']=='on')
  {
  setcookie('CrazyStat_DoNotCount_'.md5($config_logfile_folder.$config_salt_str),'true',time()+60*60*24*30);
  $_SESSION['cookie']=true;
  }
 elseif(!$_SESSION['cookie'] && isset($_COOKIE['CrazyStat_DoNotCount_'.md5($config_logfile_folder.$config_salt_str)]))
  {
  setcookie('CrazyStat_DoNotCount_'.md5($config_logfile_folder.$config_salt_str),'false',time()-3600);
  $_SESSION['cookie']=false;
  }
 // Change password
 if(isset($_POST['change_pass']))
  {
  if(empty($_POST['passwort_neu']) || empty($_POST['passwort_neu2']) || $_POST['passwort_neu']!=$_POST['passwort_neu2'] || (!empty($_POST['md5neu']) && !empty($_POST['md5neu2']) && $_POST['md5neu2']!=$_POST['md5neu']))
   {
   session_destroy();
   $meldung_fehler.=L_PASSWORD_MES_ERR_NEW_INVALID.'<br />'.L_PASSWORD_MES_ERR_NOT_CHANGED.'<br /><a href="show_stat.php?logout=1&change_pass=1">'.L_PASSWORD_MES_ERR_RETRY.'</a>';
   }
  else
   {
   require('../usr/config_pass.php');
   if($config_stat_password_md5 && isset($_POST['md5neu'])) $_POST['passwort_neu']=$_POST['md5neu'];
   elseif($config_stat_password_md5) $_POST['passwort_neu']=md5($_POST['passwort_neu'].$config_salt_str);
   
   $config_stat_user[$_SESSION['username']]=$_POST['passwort_neu'];
   @$pass_file=fopen('../usr/config_pass.php','w');
   if($pass_file===false)
    {
    session_destroy();
    $meldung_fehler.=L_PASSWORD_MES_ERR_WRITING_FAILED.'<br /><a href="show_stat.php?logout=1&change_pass=1">'.L_PASSWORD_MES_ERR_RETRY.'</a>';
    }
   else
    {
    fwrite($pass_file,'<?php $config_salt_str='.var_export($config_salt_str,true).'; $config_stat_user='.var_export($config_stat_user,true).'; ?>'); //<?php
    fclose($pass_file);
    $_SESSION['passwort']=$_POST['passwort_neu'];
    $meldung_ok.=L_PASSWORD_MES_OK_CHANGED."\n";
    }
   }
  }
 // end of change password
 }
else // Login-form
 {
 if(!isset($_SESSION['login_rand'])) $_SESSION['login_rand']=mt_rand();
 
 // get the current random value to salt the password
 if(isset($_GET['get_rand'])) 
  {
  echo $_SESSION['login_rand'];
  exit;
  }
  
 if(isset($noForm) && $noForm) die('<!-- NOT_LOGGED_IN -->'.L_PASSWORD_MES_ERR_NOT_LOGGED_IN.'<br /><a href="show_stat.php">'.L_PASSWORD_MES_ERR_RELOGIN.'</a>');
 header('Content-Type: text/html; charset=UTF-8');
 echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>CrazyStat 1.70</title>
  <link href="<?php if(!is_file('style.css') && is_file('../style.css')) echo '../'; ?>style.css" rel="stylesheet" type="text/css" />
  <link href="<?php if(!is_file('style2.css') && is_file('../style2.css')) echo '../'; ?>style2.css" rel="stylesheet" type="text/css" />
  <meta name="generator" content="CrazyStat" />
  <meta http-equiv="expires" content="0" />
  <script type="text/javascript" src="ajax.js"></script>
  <script type="text/javascript">
  window.onload=checkAjax;
  </script>
  <?php if(is_file('extensions/md5.js')) { ?>
  <script type="text/javascript" src="extensions/md5.js"></script>
  <script type="text/javascript">
  //<![CDATA[
  var rand=<?php echo $_SESSION['login_rand']; ?>;
  var salt='<?php echo addslashes($config_salt_str); ?>';
  
  /*
  Refresh the random value for salting the PW in case the session timed out
  */
  function refresh_rand()
   {
   if(noAjax==false)
    {
    current_time=new Date();          // time to append as get-parameter to avoid browser caching
    ajaxObj_Refresh_Rand=ajax();
    ajaxObj_Refresh_Rand.open('get','password_protect.php?<?php echo htmlspecialchars(SID); ?>&get_rand=1&'+current_time.getTime(),false);
    ajaxObj_Refresh_Rand.send(null);
    rand=ajaxObj_Refresh_Rand.responseText;
    }
   }  
   
   
  function encPass()
   {
   var pass2=document.getElementById('md5Input').value;
   if(pass2=='')
    {
    var pass=document.getElementById('passInput').value;
    /*
    synchronously refresh the rand-value, just in case it is not valid
    anymore because the session timed out or was destroyed. Otherwise the correct
    password would not be accepted.  
    */ 
    refresh_rand();
    pass2=MD5(MD5(pass+salt)+rand);
    document.getElementById('md5Input').value=pass2;
    document.getElementById('passInput').value='********';
    <?php if($config_stat_password_md5 && isset($_GET['change_pass'])) { ?>
    var passNeu=document.getElementById('passwort_neuInput').value;
    var passNeu2=document.getElementById('passwort_neu2Input').value;
    document.getElementById('md5neuInput').value=MD5(passNeu+salt);
    document.getElementById('md5neu2Input').value=MD5(passNeu2+salt);
    document.getElementById('passwort_neuInput').value='********';
    document.getElementById('passwort_neu2Input').value='********';
    <?php } ?>
    }
   }
  //]]>
  </script>
  <?php } ?>
  </head>
 <body id="body">
   <div align="center">
    <div id="outer_main">
     <h1><img src="<?php echo ((!is_file('img/crazystat.gif') && is_file('../img/crazystat.gif'))?'../':''); ?>img/crazystat.gif" alt="CrazyStat" title="" width="146" height="35" /></h1>

     <div id="panel"><div class="reiter" id="r0_0"><a href="index.php"><?php echo L_LOGIN_MENU_HOME; ?></a></div><div class="reiter" id="r1_<?php echo (isset($_GET['change_pass'])?'0':'1');  ?>" style="border-right: 1px solid black"><?php echo (isset($_GET['change_pass'])?'<a href="'.htmlentities($_SERVER['PHP_SELF']).'">'.L_LOGIN_MENU_LOGIN.'</a>':L_LOGIN_MENU_LOGIN); ?></div><div class="reiter" id="r2_<?php echo (isset($_GET['change_pass'])?'1':'0');  ?>"><?php echo (!isset($_GET['change_pass'])?'<a href="'.htmlentities($_SERVER['PHP_SELF']).'?change_pass">'.L_LOGIN_MENU_CHANGE_PASSWORD.'</a>':L_LOGIN_MENU_CHANGE_PASSWORD); ?></div><div style="clear:left"></div></div>
     <div id="inner_main">

      <?php if(!isset($_GET['change_pass'])) { ?>
      <h2><?php echo L_PASSWORD_PLEASE_LOGIN; ?></h2>
      <form method="post"<?php if(is_file('extensions/md5.js')) echo ' onsubmit="encPass()"'; ?> action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      <table style="width:450px">
      <tr><td><?php echo L_PASSWORD_USERNAME; ?>:</td><td><input type="text" name="username" style="width:200px" /></td></tr>
      <tr><td><?php echo L_PASSWORD_PASSWORD; ?>:</td><td><input type="password" name="passwort" style="width:200px" id="passInput" /></td></tr>
      <?php
      if(!$config_stat_lang_fix) {
       echo '<tr><td>'.L_LANGUAGE.'</td><td><select name="lang">';
       $dir_handle=opendir(dirname(__FILE__).'/lang');
       $lang_files=array();
       while(false !== ($file=readdir($dir_handle)))
        {
        if(is_file(dirname(__FILE__).'/lang/'.$file) && $file[0]!='.')
         {                   
         $lang_files[]=$file;
         }
        }
       closedir($dir_handle);
       natsort($lang_files);
       foreach($lang_files as $file)
        {
        $id=str_replace('.php','',$file);
        if($id==$config_stat_lang) $selected=' selected="selected"';
        else $selected='';
        echo '<option '.$selected.'>'.htmlentities($id).'</option>';
        }
       echo '</select></td></tr>';
       }
      ?>
      </table>
      <div style="margin-bottom: 10px; margin-top: 10px">
       <input type="checkbox" name="sperre_pc" <?php
       $check=false;
       $logdatei_ordner=$config_logfile_folder;
       foreach($config_stat_user as $user=>$pass)
        {
        if(isset($user_config[$user]['logdatei_ordner'])) $logdatei_ordner=$user_config[$user]['logdatei_ordner'];
        if(isset($_COOKIE['CrazyStat_DoNotCount_'.md5($logdatei_ordner.$config_salt_str)]) && $_COOKIE['CrazyStat_DoNotCount_'.md5($logdatei_ordner.$config_salt_str)]=='true')
         {
         $check=true;
         break;
         }
        }      
       if($check) echo 'checked="checked"'; ?> /> <?php echo L_PASSWORD_DO_NOT_COUNT; ?><br />
      </div>
      <div>
       <input type="submit" value="Login" onclick="this.disabled=true; this.value='<?php echo L_PASSWORD_PLEASE_WAIT; ?>'; document.getElementById('body').style.cursor='wait'; this.form.submit(); " />
      </div>
      <input type="hidden" name="ajax" value="0" id="ajaxInput" />
      <input type="hidden" name="md5" value="" id="md5Input" />
      <input type="hidden" name="<?php echo htmlspecialchars(session_name()); ?>" value="<?php echo htmlspecialchars(session_id()); ?>" />
      </form>
      <?php
       if(isset($_POST['passwort']) || isset($_POST['username'])) $meldung_fehler.=L_PASSWORD_MES_ERR_WRONG_DATA."\n";
       if(isset($_GET['logout']))  $meldung_ok.=L_PASSWORD_MES_OK_THANK_YOU."<br />\n<i>".L_PASSWORD_MES_SUPPORT_CRAZYSTAT."</i>\n";
       if(isset($meldung_ok)) echo '<p class="meldung_ok">'.$meldung_ok.'</p>';
       if(isset($meldung_fehler)) echo '<p class="meldung_fehler">'.$meldung_fehler.'</p>';
      ?>
      <noscript><p class="meldung_fehler"><?php echo L_PASSWORD_NO_JAVASCRIPT; ?></p></noscript>
      <?php 
      if(!is_file('extensions/md5.js')) echo '<p class="meldung_fehler">'.L_PASSWORD_MSG_ERR_NO_MD5JS.'</p>';
      } else { ?>
      <h2><?php echo L_PASSWORD_CHANGE_PASSWORD; ?></h2>
      <form method="post"<?php if(is_file('extensions/md5.js')) echo ' onsubmit="encPass()"'; ?> action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      <table style="width: 450px">
      <tr><td><?php echo L_PASSWORD_USERNAME; ?>:</td><td><input type="text" name="username" style="width:200px" /></td></tr>
      <tr><td><?php echo L_PASSWORD_OLD_PASSWORD; ?>:</td><td><input type="password" name="passwort" style="width:200px" id="passInput" /></td></tr>
      <tr><td><?php echo L_PASSWORD_NEW_PASSWORD; ?>:</td><td><input type="password" name="passwort_neu" id="passwort_neuInput" style="width:200px" /></td></tr>
      <tr><td><?php echo L_PASSWORD_REPEAT_PASSWORD; ?>:</td><td><input type="password" name="passwort_neu2" id="passwort_neu2Input" style="width:200px" /></td></tr>
      </table>
      <div style="margin-bottom: 10px; margin-top: 10px">
       <input type="submit" value="<?php echo L_PASSWORD_CHANGE_AND_LOGIN; ?>" onclick="this.disabled=true; this.value='<?php echo L_PASSWORD_PLEASE_WAIT; ?>'; document.getElementById('body').style.cursor='wait'; this.form.submit(); " />
      </div>
      <input type="hidden" name="ajax" value="0" id="ajaxInput" />
      <input type="hidden" name="md5" value="" id="md5Input" />
      <input type="hidden" name="md5neu" value="" id="md5neuInput" />
      <input type="hidden" name="md5neu2" value="" id="md5neu2Input" />
      <input type="hidden" name="change_pass" value="true" />
      <input type="hidden" name="<?php echo htmlspecialchars(session_name()); ?>" value="<?php echo htmlspecialchars(session_id()); ?>" />
      </form>
      <noscript><p class="meldung_fehler"><?php echo L_PASSWORD_NO_JAVASCRIPT; ?></p></noscript>       
      <?php if(!$config_stat_password_md5) { ?>
      <p class="meldung_fehler"><?php echo L_PASSWORD_MSG_ERR_NOMD5; ?></p>             
      <?php }
      if(!is_file('extensions/md5.js')) echo '<p class="meldung_fehler">'.L_PASSWORD_MSG_ERR_NO_MD5JS.'</p>';
      } ?>
     </div>
    </div>
    <p class="copyright">&copy; Copyright 2004-2011 <a href="<?php echo 'http://'.($config_stat_lang=='de'?'www':'en').'.christosoft.de'; ?>" target="_blank">Christopher Kramer</a></p>
   </div>
  </body>
  </html>
 <?php
 exit;
 }
?>
