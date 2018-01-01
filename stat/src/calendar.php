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

*** src/calendar.php ***
Function:          generates a form to set the period of a module
Directly opened:   no
Included:          by src/show_stat.php (Popup/Lytebox)
*/

require_once('general_include.php');

if(!isset($_REQUEST['module']) || !in_array($_REQUEST['module'],$list_modules))
 {
 $msg=L_MSG_ERR_NO_MODULE.' '.L_MSG_ERR_INCLUDE_ONLY;
 $module=false;
 }
else $module=$_REQUEST['module'];

if((isset($_REQUEST['rel']) && $_REQUEST['rel']) || ($config_stat_calendar_autorel && !isset($_REQUEST['rel']) && isset($_SESSION['set_'.$module.'_time_rel']) && $_SESSION['set_'.$module.'_time_rel'])) $rel=true;
else $rel=false;


header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title><?php echo L_CALENDAR_TITLE; ?></title>
  <?php if(is_file("extensions/calendarpopup.js")) { $script=true; ?>
  <script type="text/javascript" src="extensions/calendarpopup.js"></script>
  <script type="text/javascript"> document.write(getCalendarStyles()); </script>
  <?php } else $script=false; ?>
  <script type="text/javascript">
  function checkboxes(box)
   {
   if(document.getElementById(box).checked==true && box=='set_span')
    {
    if(document.getElementById('set_month')) document.getElementById('set_month').checked=false;
    document.getElementById('set_year').checked=false;
    }
   if(document.getElementById(box).checked==true && (box=='set_year' || box=='set_month'))
    {
    document.getElementById('set_span').checked=false;
    if(box=='set_month') document.getElementById('set_year').checked=true;
    }
   if(document.getElementById(box).checked==false && box=='set_year')
    {
    if(document.getElementById('set_month')) document.getElementById('set_month').checked=false;
    }
   }
   
  function closeCalendar()
   {
   if(!opener && !parent.myLytebox)
    {
    // somehow, the calendar was neither opened in Lytebox nor a new window, but JS works, so use location.href to go on
    location.href='show_stat.php?<?php echo SIDX; ?>';
    }
   else <?php echo ($config_stat_ext_lytebox?'parent.myLytebox.end();':'window.close()'); ?>
   }
   
  function presetchange()
   {
   var preset=document.getElementById('rel_preset').value;
   var start_str='';
   var end_str='';
   var name_str='';
   switch(preset)
    {
    case 'Today': start_str='today'; end_str='tomorrow -1second'; name_str='%Y/%m/%d'; break;
    case 'This week': start_str='%Y-W%W-1'; end_str='%Y-W%W-1 +1week -1second'; name_str='%Y-W%W'; break;
    case 'This month': start_str='%Y/%m/1'; end_str='%Y/%m/1 +1month -1second'; name_str='%Y/%m';break;
    case 'This year': start_str='%Y/1/1'; end_str='%Y/1/1 +1year -1second'; name_str='%Y'; break;
    }
   document.getElementById('rel_start').value=start_str;
   document.getElementById('rel_end').value=end_str;
   document.getElementById('rel_name').value=name_str;
   }
   
  function  is_custom()
   {
   document.getElementById('rel_preset').value='Custom';
   }
  </script>
  <meta name="generator" content="CrazyStat" />
  <meta http-equiv="expires" content="0" />
  <link href="style.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
  .meldung
   {
   font-size:10pt;
   }
  </style>
  <?php
  if(isset($_POST['action']) && $_POST['action']==L_OK && $module!==false)
   {
   $error=false;
   if(!$rel)
    {
    $set_year=(isset($_POST['set_year']) && $_POST['set_year']=='on');
    $set_month=(isset($_POST['set_month']) && $_POST['set_month']=='on');
    $set_span=(isset($_POST['set_span']) && $_POST['set_span']=='on');

    $year=$_POST['year'];
    if($year=='input')
     {
     if(isset($_POST['yearIn']) && is_numeric($_POST['yearIn'])) $year=$_POST['yearIn'];
     else $error=L_CALENDAR_MSG_ERR_YEAR_INVALID;
     }

    if($error===false && ($set_span || $set_year))
     {
     if($set_span)
      {
      $spanne_start=strtotime($_POST['spanne_start']);
      $spanne_ende=strtotime($_POST['spanne_ende'])-1;
      $_SESSION['set_'.$module.'_time_name']='';
      }
     elseif($set_year && !$set_month)
      {
      $spanne_start=mktime(0,0,0,1,1,$year);
      $spanne_ende=mktime(23,59,59,12,31,$year);
      $_SESSION['set_'.$module.'_time_name']='xx/'.$year;
      }
     elseif($set_year && $set_month)
      {
      $month=$_POST['month'];
      $spanne_start=mktime(0,0,0,$month,1,$year);
      $spanne_ende=mktime(0,0,0,$month+1,1,$year)-1;
      $_SESSION['set_'.$module.'_time_name']=$month.'/'.$year;
      }
     $_SESSION['set_'.$module.'_time_span']=true;
     $_SESSION['set_'.$module.'_time_start']=$spanne_start;
     $_SESSION['set_'.$module.'_time_end']=$spanne_ende;
     }
    elseif($set_month) $error=L_CALENDAR_MSG_ERR_MONTH_ONLY;
    else $_SESSION['set_'.$module.'_time_span']=false;
    $_SESSION['set_'.$module.'_time_rel']=false;
    unset($_SESSION['set_'.$module.'_time_rel_startid']);
    unset($_SESSION['set_'.$module.'_time_rel_start']);
    unset($_SESSION['set_'.$module.'_time_rel_end']);
    unset($_SESSION['set_'.$module.'_time_rel_name']);
    }
   else // rel
    {
    echo "rel";
    $_SESSION['set_'.$module.'_time_rel']=true;
    $_SESSION['set_'.$module.'_time_rel_start']=$_REQUEST['rel_start'];
    $_SESSION['set_'.$module.'_time_rel_end']=$_REQUEST['rel_end'];
    $_SESSION['set_'.$module.'_time_rel_name']=$_REQUEST['rel_name'];
    $_SESSION['set_'.$module.'_time_rel_startid']=$_REQUEST['rel_startid'];
    }
   if($error===false)
    {
    $link='show_stat.php?'.SIDX.'&amp;changed='.$module;
    // opener.window.location.href='show_stat.php?".SIDX."&changed=".$module."';
    echo '<script type="text/javascript">
     if(!opener && !parent.myLytebox) {
     // somehow, the calendar was neither opened in Lytebox nor a new window, but JS works, so use location.href to go on
     location.href="'.$link.'"; 
     }
     else {
     	'.($config_stat_ext_lytebox?'parent':'opener').'.refresh("'.$module.'","mode=refresh");
     	'.($config_stat_ext_lytebox?'parent.myLytebox.end()':'window.close()').';
     }
     </script>';
    $msg='<noscript><p class="meldung">'.L_CALENDAR_MSG_ERR_NO_JS.' <a href="'.$link.'">'.L_MSG_ERR_CONTINUE.'</a></p></noscript>';
    }
   else $msg=$error;
   }
  ?>
 </head>
 <body>
 <h2><?php echo L_CALENDAR_TITLE; ?></h2>
 <h3><?php if($module!==false) echo constant('L_MODULES_'.strtoupper($module).'_P'); ?></h3>
 <?php
 if($rel) { ?><a href="calendar.php?<?php echo SIDX.'&amp;module='.$module; ?>&amp;rel=0"><?php echo L_CALENDAR_ABSOLUTE.'</a> | '.L_CALENDAR_RELATIVE; }
 else { echo L_CALENDAR_ABSOLUTE.' | <a href="calendar.php?'.SIDX.'&amp;module='.$module.'&amp;rel=1">'.L_CALENDAR_RELATIVE.'</a>'; } ?>
 <?php
  echo (isset($msg)?'<p class="meldung">'.$msg.'</p>':'');
 ?>
 <form method="post" action="calendar.php">
 <table style="font-size:70%; width:100%">
 <?php
 if($module!==false && !$rel)
  {
 ?>
 <tr><td><input type="checkbox" onclick="this.blur();" onchange="checkboxes('set_year')" name="set_year" id="set_year" /></td><td><?php echo L_CALENDAR_LIMIT_YEAR; ?>:</td></tr>
 <tr><td>&nbsp;</td><td>
 <?php
  $year=date('Y');
  echo '<table>';
  for($i=0;$i<=3;$i++)
   {
   $x=$year-$i;
   if(($i%2)==0) echo '<tr>';
   echo '<td><input type="radio" name="year" value="';
   if($i!=3)
    echo $x.'"'.($i==0?' checked="checked"':'').' onchange="document.getElementById(\'set_year\').checked=true; checkboxes(\'set_year\')" />'.$x.'</td>';
   else
    echo 'input" id="yearInRad" onchange="document.getElementById(\'set_year\').checked=true; checkboxes(\'set_year\')" /><input type="text" name="yearIn" value="'.$x.'" size="3" onchange="document.getElementById(\'yearInRad\').checked=true; document.getElementById(\'set_year\').checked=true; checkboxes(\'set_year\');" style="width:45px" /></td>';
   if(($i%2)!=0) echo '</tr>';
   }
 ?>
 </table>
 <input type="hidden" name="rel" value="0" />
 </td>
 </tr>
 <?php
 if($module!='month')
  {
 ?>
 <tr><td><input type="checkbox" onclick="this.blur();" onchange="checkboxes('set_month')" name="set_month" id="set_month" /></td><td><?php echo L_CALENDAR_LIMIT_MONTH; ?>:</td></tr>
 <tr><td>&nbsp;</td><td>
 <?php
  $month=date('n');
  $monats_namen=explode(' ',L_CALENDAR_MONTH_ABR);
  echo '<table>';
  $i=0;
  foreach($monats_namen as $monats_name)
   {
   if($i==$month-1) $checked=' checked="checked"';
   else $checked='';
   if(round($i/2)==$i/2) echo '<tr>';
   $monatszahl=$i+1;
   if($monatszahl<10) $monatszahl='0'.$monatszahl;
   echo '<td><input type="radio" name="month" value="'.$monatszahl.'"'.$checked.' onchange="document.getElementById(\'set_month\').checked=true; checkboxes(\'set_month\')" />'.$monats_name.'</td>';
   if(round($i/2)!=$i/2) echo '</tr>';
   $i++;
   }
  echo '</table></td></tr>';
  } // $module!=month
 ?>
 <tr><td><input type="checkbox" onclick="this.blur();" onchange="checkboxes('set_span')" name="set_span" id="set_span"<?php if(isset($_SESSION['set_'.$module.'_time_span']) && $_SESSION['set_'.$module.'_time_span']) echo ' checked="checked"'; ?> /></td><td><?php echo L_CALENDAR_LIMIT_PERIOD; ?>:</td></tr>
 <tr><td>&nbsp;</td><td>
 <?php if($script) { 
 function str2JSarray($str)
  {
  $arr=explode(' ',$str);
  $i=1;
  $m=count($arr);
  foreach($arr as $el)
   {
   echo '"'.$el.'"';
   if($i!=$m) echo ',';
   $i++;
   }
  }
 $js_date_format=str_replace('Y','yyyy',str_replace('d','dd',str_replace('m','MM',L_DATE_FORMAT))); 
 ?>
 <script language="javascript" id="js13" type="text/javascript">
 var cal13 = new CalendarPopup("kalenderdiv1");
 cal13.setMonthNames(<?php str2JSarray(L_CALENDAR_MONTH_NAMES); ?>);
 cal13.setDayHeaders(<?php str2JSarray(L_CALENDAR_WEEKDAYS_ABR); ?>);
 cal13.setWeekStartDay(<?php echo L_CALENDAR_WEEK_START_DAY; ?>);
 cal13.setTodayText('<?php echo L_CALENDAR_TODAY; ?>');
 cal13.autoPosition=false;
 </script>
 <?php } ?>
 <table>
 <tr><td><?php if($script) { ?><a href="nojs.php" onclick="document.getElementById('set_span').checked=true; checkboxes('set_span'); cal13.select(document.forms[0].spanne_start,'anchor13','<?php echo $js_date_format; ?>'); return false;" name="anchor13" id="anchor13"><?php echo L_CALENDAR_START; ?></a><?php } else echo L_CALENDAR_START ?>:</td><td><input type="text" name="spanne_start" value="<?php echo (isset($_SESSION['set_'.$module.'_time_span']) && $_SESSION['set_'.$module.'_time_span']?date(L_DATE_FORMAT,$_SESSION['set_'.$module.'_time_start']):date(L_DATE_FORMAT)); ?>" size="10" onchange="document.getElementById('set_span').checked=true; checkboxes('set_span')" /></td></tr>
 <tr><td><?php if($script) { ?><a href="nojs.php" onclick="document.getElementById('set_span').checked=true; checkboxes('set_span'); cal13.select(document.forms[0].spanne_ende,'anchor14','<?php echo $js_date_format; ?>',(document.forms[0].spanne_ende.value=='')?document.forms[0].spanne_start.value:null); return false;" name="anchor14" id="anchor14"><?php echo L_CALENDAR_END; ?></a><?php } else echo L_CALENDAR_END; ?>:</td><td><input type="text" name="spanne_ende" value="<?php echo (isset($_SESSION['set_'.$module.'_time_span']) && $_SESSION['set_'.$module.'_time_span']?date(L_DATE_FORMAT,$_SESSION['set_'.$module.'_time_end']+1):date(L_DATE_FORMAT,mktime(0,0,0,date('m'),date('d')+1,date('Y')))); ?>" size="10" onchange="document.getElementById('set_span').checked=true; checkboxes('set_span')" /></td></tr>
 </table>
 <?php if($script) { ?><div id="kalenderdiv1" style="position:absolute; left: 10px; bottom: 130px; visibility:hidden;background-color:white;layer-background-color:white;"></div><?php } ?>
 </td></tr>
 <?php 
  } // $module!==false && !rel
 elseif($module!==false) // ->rel
  {
 ?>
 <tr><td><?php echo L_CALENDAR_RELATIVE_PRESET; ?></td><td><noscript style="color:red">Presets require JavaScript. As a work-around, you can copy and paste the following strings into "Start" and "End":
 <table>
  <tr><th><?php echo L_CALENDAR_RELATIVE_PRESET; ?></th><th><?php echo L_CALENDAR_START; ?></th><th><?php echo L_CALENDAR_END; ?></th></tr>
  <tr><td><?php echo L_CALENDAR_TODAY; ?></td><td>today</td><td>tomorrow -1second</td></tr>
  <tr><td><?php echo L_CALENDAR_RELATIVE_THIS_WEEK; ?></td><td>%Y-W%W-1</td><td>%Y-W%W-1 +1week -1second</td></tr>
  <tr><td><?php echo L_CALENDAR_RELATIVE_THIS_MONTH; ?></td><td>%Y/%m/1</td><td>%Y/%m/1 +1month -1second</td></tr>
  <tr><td><?php echo L_CALENDAR_RELATIVE_THIS_YEAR; ?></td><td>%Y/1/1</td><td>%Y/1/1 +1year -1second</td></tr>
 </table>
 </noscript>
  <select name="rel_presets" id="rel_preset" onchange="presetchange()">
   <option value="Custom"<?php echo ((isset($_SESSION['set_'.$module.'_time_rel']) && $_SESSION['set_'.$module.'_time_rel'])?' selected="selected"':''); ?>><?php echo L_CALENDAR_RELATIVE_CUSTOM; ?></option>
   <option value="Today"><?php echo L_CALENDAR_TODAY; ?></option>
   <option value="This week"><?php echo L_CALENDAR_RELATIVE_THIS_WEEK; ?></option>
   <option value="This month"<?php echo ((isset($_SESSION['set_'.$module.'_time_rel']) && $_SESSION['set_'.$module.'_time_rel'])?'':' selected="selected"'); ?>><?php echo L_CALENDAR_RELATIVE_THIS_MONTH; ?></option>
   <option value="This year"><?php echo L_CALENDAR_RELATIVE_THIS_YEAR; ?></option>   
  </select>
 </td></tr>
 <tr><td><?php echo L_CALENDAR_START; ?>*</td><td><input type="text" id="rel_start" name="rel_start" value="<?php echo (isset($_POST['rel_start'])?$_POST['rel_start']:(isset($_SESSION['set_'.$module.'_time_rel_start'])?$_SESSION['set_'.$module.'_time_rel_start']:'%Y/%m/1')); ?>" onchange="is_custom()" /></td></tr>
 <tr><td>&nbsp;</td><td><?php if(isset($_POST['rel_start']) && isset($_POST['action']) && $_POST['action']==L_CALENDAR_RELATIVE_CHECK) echo date(L_DATE_FORMAT.' - '.L_TIME_FORMAT,parse_str_to_time($_POST['rel_start'])); ?></td></tr>
 <tr><td><?php echo L_CALENDAR_END; ?>*</td><td><input type="text" id="rel_end" name="rel_end" value="<?php echo (isset($_POST['rel_end'])?$_POST['rel_end']:(isset($_SESSION['set_'.$module.'_time_rel_end'])?$_SESSION['set_'.$module.'_time_rel_end']:'%Y/%m/1 +1month -1second')); ?>" onchange="is_custom()" /></td></tr>
 <tr><td>&nbsp;</td><td><?php if(isset($_POST['rel_end']) && isset($_POST['action']) && $_POST['action']==L_CALENDAR_RELATIVE_CHECK) echo date(L_DATE_FORMAT.' - '.L_TIME_FORMAT,parse_str_to_time($_POST['rel_end'])); ?></td></tr>
 <tr><td><?php echo L_CALENDAR_START; ?> #</td><td><input type="text" id="rel_startid" name="rel_startid" value="<?php echo (isset($_POST['rel_startid'])?$_POST['rel_startid']:(isset($_SESSION['set_'.$module.'_time_rel_startid'])?$_SESSION['set_'.$module.'_time_rel_startid']:'')); ?>" onchange="is_custom()" /></td></tr>
 <tr><td>&nbsp;</td><td><?php if(isset($_POST['rel_startid']) && isset($_POST['action']) && $_POST['action']==L_CALENDAR_RELATIVE_CHECK) echo calc_start_id($_POST['rel_startid']); ?></td></tr>
 <tr><td><?php echo L_NAME; ?>**</td><td><input type="text" id="rel_name" name="rel_name" value="<?php echo (isset($_POST['rel_name'])?$_POST['rel_name']:(isset($_SESSION['set_'.$module.'_time_rel_name'])?$_SESSION['set_'.$module.'_time_rel_name']:'%Y/%m')); ?>" onchange="is_custom()" /></td></tr>
 <tr><td>&nbsp;</td><td><?php if(isset($_POST['rel_name']) && isset($_POST['action']) && $_POST['action']==L_CALENDAR_RELATIVE_CHECK) echo time_replace_chars($_POST['rel_name']); ?></td></tr>
 
 <tr><td colspan="2">
 <a href="../doc/relative_time-spans.html" target="_blank"><?php echo L_CALENDAR_RELATIVE_HELP; ?></a>
 <input type="hidden" name="rel" value="1" />
 </td></tr> 
 <?php
  }
 ?>
 <tr><td colspan="2" style="text-align:center"><?php echo ($rel?'<input type="submit" name="action" value="'.L_CALENDAR_RELATIVE_CHECK.'" /> ':''); ?><input type="submit" name="action" value="<?php echo L_OK; ?>" /> <input type="button" value="<?php echo L_CLOSE; ?>" onclick="closeCalendar();" /></td></tr>
 </table>
 <?php
 if($module!==false) echo '<input type="hidden" name="module" value="'.$module.'" />';
 ?>
 <input type="hidden" name="<?php echo htmlspecialchars(session_name()); ?>" value="<?php echo htmlspecialchars(session_id()); ?>" />
 </form>
 </body>
</html>