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

*** src/preset_editor.php ***
Funktion:    GUI to edit presets
Aufrufbar:   ja
Eingebunden: von show_stat.php (Link)
*/

require_once('general_include.php');
require_once('preset.php');

if((!$config_stat_guest_preset_manage && !$config_stat_password_protect) || !$config_stat_user_preset_manage) die(L_PRESETEDITOR_MSG_ERR_GUEST);

$p_modules=generate_preset();

// delete preset (not yet confirmed)
if(isset($_GET['delete']) && isset($config_preset[$_GET['delete']]))
 {
 $message='<p>'.L_PRESETEDITOR_MSG_PRESET_DELETE.': '.$config_preset[$_GET['delete']]['name'].' ('.$_GET['delete'].')</p>';
 $message.='<form action="preset_editor.php" method="post"><input type="hidden" name="delete2" value="'.$_GET['delete'].'" /><input type="submit" name="button" value="'.L_DELETE.'" /><input type="submit" name="button" value="'.L_CANCEL.'" /><input type="hidden" name="'.htmlspecialchars(session_name()).'" value="'.htmlspecialchars(session_id()).'" /></form>';
 }
 
 
// delete preset (confirmed)
if(isset($_REQUEST['delete2']) && (!isset($_POST['button']) || $_POST['button']==L_DELETE) && isset($config_preset[$_REQUEST['delete2']]))
 {
 // delete preset-file
 unlink('../usr/presets/'.$_REQUEST['delete2'].'.php');
 // delete all cachefiles for this preset
 delete_cachefiles_for_preset($_REQUEST['delete2']);
 $message='<p>'.L_PRESETEDITOR_MSG_PRESET_DELETED.': '.$config_preset[$_REQUEST['delete2']]['name'].'</p>';
 // unload the preset 
 unset($config_preset[$_REQUEST['delete2']]);
 }
 
// change cache-setting
if(isset($_GET['preset']) && isset($config_preset[$_GET['preset']]) && isset($_GET['cache']) && (!isset($config_preset[$_GET['preset']]['cacheable']) || $config_preset[$_GET['preset']]['cacheable']))
 {
 $config_preset[$_GET['preset']]['cache']=($_GET['cache']=='1');
 $file_handle=fopen('../usr/presets/'.$_GET['preset'].'.php','w');
 fwrite($file_handle,'<?php $config_preset[\''.$_GET['preset'].'\']='.var_export($config_preset[$_GET['preset']],true).'; ?>'); //<?php 
 fclose($file_handle);
 // delete cache-files for this preset
 delete_cachefiles_for_preset($_GET['preset']);
 }

// save new preset
if(isset($_POST['save']) && !empty($_POST['p_name']))
 {
 if(isset($p_modules['ABS_TIME'])) unset($p_modules['ABS_TIME']);
 $new_preset=array();
 $new_preset['modules']=$p_modules;
 $new_preset['name']=$_POST['p_name'];
 $new_preset['cache']=($_POST['p_cache']?true:false);
 
 for($i=0; is_file('../usr/presets/preset'.$i.'.php'); $i++) {}
 $file_handle=fopen('../usr/presets/preset'.$i.'.php','w');
 fwrite($file_handle,'<?php $config_preset[\'preset'.$i.'\']='.var_export($new_preset,true).'; ?>'); //<?php 
 fclose($file_handle);
 $message='<p>'.L_PRESETEDITOR_MSG_PRESET_SAVED.'</p>';
 // load the preset
 $config_preset['preset'.$i]=$new_preset; 
 }
header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>CrazyStat - <?php echo L_PRESETEDITOR_MANAGE_PRESETS; ?></title>
 <meta name="generator" content="CrazyStat" />
 <meta http-equiv="expires" content="0" />
 <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php if(isset($message)) echo $message; ?>
<h2><?php echo L_PRESETEDITOR_MANAGE_PRESETS; ?></h2>
<table>
 <thead>
  <tr><th><?php echo L_PRESETEDITOR_ID; ?></th><th><?php echo L_NAME; ?></th><th><?php echo L_PRESETEDITOR_CACHE_SIZE; ?></th><th></th></tr>
 </thead>
 <tbody>
 <?php
 foreach($config_preset as $preset_id=>$settings)
  {
  if($settings['cache'])
   {
   $cachefiles=get_cachefiles_for_preset($preset_id);
   $cachesize=0;
   foreach($cachefiles as $cachefile)
    {
    $cachesize+=filesize('../usr/cache/'.$cachefile);
    }
   $cachesize=round($cachesize/1000).'KB';
   }
  else
   {
   $cachesize='';
   }
  if(!isset($settings['cacheable']) || $settings['cacheable'])
   { 
   $cache_link='<a href="preset_editor.php?'.SIDX.'&amp;preset='.$preset_id.'&amp;cache='.($settings['cache']?'0':'1').'">';
   if($settings['cache']) $cache_image='<img src="img/cached.png" title="'.L_PRESETEDITOR_CACHE_NOT.'" alt="'.L_PRESETEDITOR_CACHE_NOT.'" />';
   else $cache_image='<img src="img/cache.png" title="'.L_PRESETEDITOR_CACHE.'" alt="'.L_PRESETEDITOR_CACHE.'" />'; 
   $cache_link2='</a>';
   }
  else
   {
   $cache_link='';
   $cache_link2='';
   $cache_image='<img src="img/cache_uncacheable.png" title="'.L_PRESETEDITOR_CACHE_UNCACHEABLE.'" alt="'.L_PRESETEDITOR_CACHE_UNCACHEABLE.'" />';
   } 
  echo '<tr><td>'.$preset_id.'</td><td>'.$settings['name'].'</td><td>'.$cachesize.'</td><td>'.$cache_link.$cache_image.$cache_link2.'<a href="preset_editor.php?'.SIDX.'&amp;delete='.$preset_id.'"><img src="img/delete.png" alt="'.L_DELETE.'" title="'.L_DELETE.'" /></a></td></tr>';
  }
 ?>
 </tbody>
</table>
<h3><?php echo L_PRESETEDITOR_SAVE_PRESET; ?></h3>
<p><?php echo L_PRESETEDITOR_SAVE_PRESET_TEXT; ?></p>
<?php


if(isset($p_modules['ABS_TIME']))
 {
 echo '<p>'.L_PRESETEDITOR_SAVE_PRESET_MSG_ABS.': ';
 foreach($p_modules['ABS_TIME'] as $module)
  {
  echo constant('L_MODULES_'.strtoupper($module).'_P').' ';
  }
 echo '<br />';
 echo L_PRESETEDITOR_SAVE_PRESET_MSG_ABS2.'</p>'; 
 }

$check=check_which_preset_exact($p_modules);
if($check!==false)  echo '<p>'.L_PRESETEDITOR_SAVE_PRESET_DUPLICATE.' '.$config_preset[$check]['name'].'<br />'.L_PRESETEDITOR_SAVE_PRESET_DUPLICATE_CANNOT_BE_SAVED.'</p>';
else {
?>
<form action="preset_editor.php" method="post">
 <input type="checkbox" name="p_cache" /> <?php echo L_PRESETEDITOR_CACHE; ?><br />
 <?php echo L_NAME;?>: <input type="text" name="p_name" /><br />
 <input type="submit" value="<?php echo L_PRESETEDITOR_SAVE_PRESET; ?>" />
 <input type="hidden" name="save" value="1" />
 <input type="hidden" name="<?php echo htmlspecialchars(session_name()); ?>" value="<?php echo htmlspecialchars(session_id()); ?>" />
</form>
<?php } ?>
</body>
</html>