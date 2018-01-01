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

*** src/logs.php ***
Funktion:    Verwaltung der Logdateien
Aufrufbar:   ja
Eingebunden: von show_stat.php (Link)
*/
require_once('general_include.php');

if(isset($_GET['delete'])) // delete a single file
 {
 $_POST['delete_x']=0;
 $_POST['logfile']=array($_GET['delete']=>true);
 }
 
if(isset($_POST['search_x']))
 { 
 $_SESSION['log_ids']=get_checked_logs(false);
 if(!empty($_SESSION['log_ids'])) header('Location: http://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/logs_search.php?'.SIDX);
 else $message='<p>'.L_LOGS_MSG_ERR_NOFILE.'<br /><a href="logs.php?'.SIDX.'">'.L_BACK.'</a></p>';
 }
elseif(isset($_POST['delete_x'])) // not confirmed yet
 {   
 $_SESSION['log_ids']=get_checked_logs(true);
 if(!empty($_SESSION['log_ids']))
  {
  $message='<p>'.L_LOGS_MSG_CONFIM_DELETE.'</p>';
  foreach($_SESSION['log_ids'] as $id)
   {
   $message.=$_SESSION['log_files'][$id].'<br />';
   }
  $message.='<form action="logs.php" method="post"><input type="hidden" name="delete2" value="true" /><input type="submit" name="button" value="'.L_DELETE.'" /><input type="submit" name="button" value="'.L_CANCEL.'" /><input type="hidden" name="'.htmlspecialchars(session_name()).'" value="'.htmlspecialchars(session_id()).'" /></form>';
  }
 else $message='<p>'.L_LOGS_MSG_ERR_NOFILE.'<br /><a href="logs.php?'.SIDX.'">'.L_BACK.'</a></p>';
 }
elseif(isset($_POST['delete2'])) // confirmed
 {   
 if($_POST['button']!=L_CANCEL && ($config_stat_password_protect || $config_stat_guest_log_delete) && $config_stat_user_log_delete)
  {
  foreach($_SESSION['log_ids'] as $id)
   {
   unlink('../usr/'.$config_logfile_folder.'/'.$_SESSION['log_files'][$id]);
   }
  }
 elseif($_POST['button']!=L_CANCEL) $message=L_LOGS_MSG_ERR_GUEST_DELETE;
 }

function get_checked_logs($include_counterfile=true)
 {
 $checked_logs=array();
 if(!empty($_POST['logfile']) && is_array($_POST['logfile']))
  {
  foreach($_POST['logfile'] as $id=>$checked)
   {
   if($checked && ($_SESSION['log_files'][$id]!=$config_count_file || $include_counterfile)) $checked_logs[]=$id;
   }
  }
 return $checked_logs;
 }

function download($datei,$neuerName)
 {
 $groesse=filesize($datei);
 @header('Content-type: text/plain');
 @header('Content-Disposition: attachment; filename='.$neuerName);
 @header('Content-Length: '.$groesse);
 @header('Pragma: no-cache');
 @header('Expires: 0');
 @readfile($datei);
 exit;
 }
 
if(isset($_GET['download']) && isset($_SESSION['log_files'][$_GET['download']]))
 {
 if(($config_stat_password_protect && $config_stat_user_log_download) || $config_stat_guest_log_download)
  {
  $dateiname=$_SESSION['log_files'][$_GET['download']];
  download('../usr/'.$config_logfile_folder.'/'.$dateiname,date('Y_m_d').'_'.$dateiname);
  }
 else $message=L_LOGS_MSG_ERR_GUEST_DOWNLOAD;
 }


header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>CrazyStat - <?php echo L_LOGS_TITLE; ?></title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <meta name="generator" content="CrazyStat" />
  <?php if(is_file('extensions/calendarpopup.js')) { $script=true; ?>
  <script type="text/javascript" src="extensions/calendarpopup.js"></script>
  <script type="text/javascript"> document.write(getCalendarStyles()); </script>
  <?php } else $script=false; ?>
  <script type="text/javascript" language="javascript">
  //<![CDATA[
  
  function selectLog(id,state)
   {
   if(id>=0) document.getElementsByName('logfile['+id+']')[0].checked=state;
   else
    {
    var id=0;
    while(document.getElementsByName('logfile['+id+']')[0])
     {
     selectLog(id,state);
     id++;
     }
    }
   }
   //]]>
  </script>
  <?php if($config_stat_ext_lytebox && is_file('extensions/lytebox.js') && is_file('extensions/lytebox.css')) { ?>
  <script type="text/javascript" language="javascript" src="extensions/lytebox.js"></script>
  <link rel="stylesheet" href="extensions/lytebox.css" type="text/css" media="screen" />
  <?php } ?>
 </head>
 <body id="body">
  <div class="menue">
    <a href="about.php" target="_blank" rel="lyteframe" rev="width: 420px; height: 380px; scrolling: no;"><img src="img/about.png" alt="<?php echo L_MENU_ABOUT; ?>" title="<?php echo L_MENU_ABOUT; ?>" /></a>
    <a href="anonymous_redirect.php?go_anonym=<?php echo 'http://'.($config_stat_lang=='de'?'www':'en').'.christosoft.de'; ?>" target="_blank"><img src="img/website.png" alt="<?php echo L_MENU_WEBSITE; ?>" title="<?php echo L_MENU_WEBSITE; ?>" /></a>
    <a href="logs.php?<?php echo SIDX.'&amp;'.time(); ?>" onclick="waitmessage();"><img src="img/refresh.png" alt="<?php echo L_REFRESH; ?>" title="<?php echo L_REFRESH; ?>" /></a>  
   <a href="show_stat.php?<?php echo SIDX; ?>"><img src="img/chart_bar.png" alt="<?php echo L_MENU_STATISTIC; ?>" title="<?php echo L_MENU_STATISTIC; ?>" /></a>
   <?php if($config_stat_password_protect) { ?><a href="logs.php?<?php echo SIDX; ?>&amp;logout=true"><img src="img/logout.png" alt="<?php echo L_LOGOUT; ?>" title="<?php echo L_LOGOUT; ?>" /></a><?php } ?>
  </div>
  <h1><img src="img/crazystat.gif" alt="CrazyStat" title="" width="146" height="35" /></h1>
  <?php
  if(!empty($message)) die($message.'</body></html>');
  ?>
  <h2><?php echo L_LOGS_TITLE; ?></h2>
  <form id="logForm" action="logs.php" method="post">
  <table class="table_pad">
  <?php
  $dir_handle=opendir('../usr/'.$config_logfile_folder);
  $id=0;
  unset($_SESSION['log_files']);
  while(false !== ($file=readdir($dir_handle)))
   {
   if(is_file('../usr/'.$config_logfile_folder.'/'.$file) && $file[0]!='.')
    {
    if($file==$config_count_file) $_SESSION['log_files'][0]=$file;
    else
     {
     $id++;
     $_SESSION['log_files'][$id]=$file;
     }
    }
   }
  closedir($dir_handle);
  natsort($_SESSION['log_files']);
  $log_files=$_SESSION['log_files'];
  $_SESSION['log_files']=array();
  $id=0;
  foreach($log_files as $file)
   {
   $_SESSION['log_files'][$id]=$file;
   $filesize=round(filesize('../usr/'.$config_logfile_folder.'/'.$file)/1024,2);
   echo '<tr><td><input type="checkbox" name="logfile['.$id.']" /></td><td>'.($file!=$config_count_file?'<a href="show_log.php?'.SIDX.'&amp;id='.$id.'">'.$file.'</a>':$file).'</td><td>'.$filesize.'&nbsp;KiB</td><td><a href="logs.php?'.SIDX.'&amp;download='.$id.'"><img src="img/save.png" alt="'.L_LOGS_BACKUP.'" /></a></td>'.($file!=$config_count_file?'<td><a href="show_log.php?'.SIDX.'&amp;id='.$id.'"><img src="img/log.png" alt="'.L_LOGS_VIEW.'" /></a></td><td><a href="logs_search.php?'.SIDX.'&amp;id='.$id.'"><img src="img/find.png" alt="'.L_LOGS_SEARCH.'" /></a></td>':'<td></td><td></td>').'<td><a href="logs.php?'.SIDX.'&amp;delete='.$id.'"><img src="img/delete.png" alt="'.L_DELETE.'" /></a></td></tr>';
   $id++;
   }
  echo '</table><input type="hidden" name="'.htmlspecialchars(session_name()).'" value="'.htmlspecialchars(session_id()).'" />';
  ?>
  <a href="nojs.php" onclick="selectLog(-1,true); return false;"><?php echo L_LOGS_SELECT_ALL; ?></a> / <a href="nojs.php" onclick="selectLog(-1,false); return false;"><?php echo L_LOGS_SELECT_NONE; ?></a> - <?php echo L_LOGS_SELECTED; ?> <!--img src="img/save_multiple.png" alt="" /--> <input type="image" name="search" value="search" src="img/find.png" alt="<?php echo L_LOGS_SEARCH; ?>" /> <input type="image" name="delete" value="delete" src="img/delete.png" alt="<?php echo L_DELETE; ?>" />
  </form>
 </body>
</html>