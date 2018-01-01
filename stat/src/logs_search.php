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

*** src/logs_search.php ***
Function:    Provide search/filter Form to searech inside logfiles
Aufrufbar:   ja
Eingebunden: von logs.php (Link)
*/
require_once('general_include.php');


$js_date_format=str_replace('Y','yyyy',str_replace('d','dd',str_replace('m','MM',L_DATE_FORMAT))); 

if(isset($_GET['id'])) $_SESSION['log_ids']=array($_GET['id']);

header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>CrazyStat - <?php echo L_LOGS_TITLE.' - '.L_LOGS_SEARCH; ?></title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <meta name="generator" content="CrazyStat" />
  <style type="text/css">
  div.condition
   {
   padding-bottom: 5px;
   }
  .calendar
   {
   visibility:hidden;
   background-color:white;
   display: inline;
   position: absolute;
   layer-background-color:white;
   }
  .anchor
   {
   display: none;
   }
  </style>
  <?php if(is_file('extensions/calendarpopup.js')) { $script=true; ?>
  <script type="text/javascript" src="extensions/calendarpopup.js"></script>
  <script type="text/javascript"> document.write(getCalendarStyles()); </script>
  <?php } else $script=false; ?>
  <script type="text/javascript" language="javascript">
  //<![CDATA[
  var rows=0;
  var calendar=<?php if($script) echo 'true'; else echo 'false'; ?>;
  var cal=[];
  function addrow()
   {
   var html_container=document.createElement('div');
   html_container.className="condition";
   var html_select=document.createElement('select');
   html_select.name="field"+rows;
   html_select.setAttribute('onchange','fieldChange('+rows+')');
   var html_names=new Array(<?php echo '"'.L_NUMBER.'", "'.L_DATE.'/'.L_TIME.'", "'.L_IP.'", "'.L_MODULES_FILE_S.'", "'.L_USERAGENT.'", "'.L_MODULES_RESOLUTION_S.' X", "'.L_MODULES_RESOLUTION_S.' Y", "'.L_MODULES_COLORDEPTH_S.' ('.L_BIT.')", "'.L_MODULES_REFERER_S.'"'; ?>);
   for(i=0;i<=8;i++)
    {
    var html_option=document.createElement('option');
    switch(i)
     {
     case 5: html_option.value='5x'; break;
     case 6: html_option.value='5y'; break;
     case 7: html_option.value='7'; break;
     case 8: html_option.value='6'; break;
     default: html_option.value=i; break;          
     }
    html_option.appendChild(document.createTextNode(html_names[i]));
    html_select.appendChild(html_option);
    }
   html_container.appendChild(html_select);
   var html_select2=document.createElement('select');
   html_select2.name="operator"+rows;
   var html_names2=new Array(<?php echo '"'.L_LOGS_SEARCH_CONTAINS.'", "'.L_LOGS_SEARCH_CONTAINS_NOT.'", "'.L_LOGS_SEARCH_UNEQUAL.'",'; ?> "<", "<=", "=", ">=", ">");
   for(i=0;i<=7;i++)
    {
    var html_option=document.createElement('option');
    html_option.value=i;    
    html_option.appendChild(document.createTextNode(html_names2[i]));
    html_select2.appendChild(html_option);
    }
   html_container.appendChild(html_select2);    
   var html_input=document.createElement('input');
   html_input.type="text";
   html_input.value="";
   html_input.name="value"+rows;
   html_input.size=50;
   html_container.appendChild(html_input);

   if(calendar)
    {
    html_kal_a=document.createElement('a');
    html_kal_a.href='#';
    html_kal_a.setAttribute('onclick','cal['+rows+'].select(document.forms[0].value'+rows+',\'anchor'+rows+'\',\'<?php echo $js_date_format; ?>\'); return false;');
    html_kal_a.name="anchor"+rows;
    html_kal_a.id="anchor"+rows;
    html_kal_a.className="anchor";
    html_kal_img=document.createElement('img');
    html_kal_img.src="img/calendar.png";
    html_kal_img.alt="<?php echo L_CALENDAR_TITLE; ?>";
    html_kal_a.appendChild(html_kal_img);
    html_container.appendChild(html_kal_a);
    html_kal_div=document.createElement("div");
    html_kal_div.id="calendardiv"+rows;
    html_kal_div.className="calendar";
    html_container.appendChild(html_kal_div);
    }
   document.getElementById('conditions').appendChild(html_container);
   if(calendar)
    {
    <?php
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
    ?>
    cal[rows] = new CalendarPopup('calendardiv'+rows);
    cal[rows].setMonthNames(<?php str2JSarray(L_CALENDAR_MONTH_NAMES); ?>);
    cal[rows].setDayHeaders(<?php str2JSarray(L_CALENDAR_WEEKDAYS_ABR); ?>);
    cal[rows].setWeekStartDay(<?php echo L_CALENDAR_WEEK_START_DAY; ?>);
    cal[rows].setTodayText('<?php echo L_CALENDAR_TODAY; ?>');
    }
   rows++;
   }
  function fieldChange(rows)
   {
   var field=document.forms[0]['field'+rows].value;
   var anchor=document.getElementById('anchor'+rows);
   var val=document.forms[0]['value'+rows];

   if(field=='1')
    {
    anchor.style.display='inline';
    val.title='<?php echo L_LOGS_VALUE; ?>: GNU Date';
    }
   else
    {
    anchor.style.display='none';
    val.title='<?php echo L_LOGS_VALUE; ?>';
    }
   }
   
   //]]>
  </script>
  <?php if($config_stat_ext_lytebox && is_file('extensions/lytebox.js') && is_file('extensions/lytebox.css')) { ?>
  <script type="text/javascript" language="javascript" src="extensions/lytebox.js"></script>
  <link rel="stylesheet" href="extensions/lytebox.css" type="text/css" media="screen" />
  <?php } ?>
 </head>
 <body onload="addrow();" id="body">
  <div class="menue">
   <a href="about.php" target="_blank" rel="lyteframe" rev="width: 420px; height: 380px; scrolling: no;"><img src="img/about.png" alt="<?php echo L_MENU_ABOUT; ?>" title="<?php echo L_MENU_ABOUT; ?>" /></a>
   <a href="anonymous_redirect.php?go_anonym=<?php echo 'http://'.($config_stat_lang=='de'?'www':'en').'.christosoft.de'; ?>" target="_blank"><img src="img/website.png" alt="<?php echo L_MENU_WEBSITE; ?>" title="<?php echo L_MENU_WEBSITE; ?>" /></a>
   <a href="logs.php?<?php echo SIDX.'&amp;'.time(); ?>" onclick="waitmessage();"><img src="img/refresh.png" alt="<?php echo L_REFRESH; ?>" title="<?php echo L_REFRESH; ?>" /></a>  
   <a href="show_stat.php?<?php echo SIDX; ?>"><img src="img/chart_bar.png" alt="<?php echo L_MENU_STATISTIC; ?>" title="<?php echo L_MENU_STATISTIC; ?>" /></a>
   <?php if($config_stat_password_protect) { ?><a href="logs.php?<?php echo SIDX; ?>&amp;logout=true"><img src="img/logout.png" alt="<?php echo L_LOGOUT; ?>" title="<?php echo L_LOGOUT; ?>" /></a><?php } ?>
  </div>
  <h1><img src="img/crazystat.gif" alt="CrazyStat" title="" width="146" height="35" /></h1>
  <h2><?php echo L_LOGS_FILTER_TITLE; ?></h2>
  <form action="show_log.php" method="post">
   <input type="hidden" value="search" name="aktion" />
   <input type="hidden" name="<?php echo htmlspecialchars(session_name()); ?>" value="<?php echo htmlspecialchars(session_id()); ?>" />
   <div id="conditions">
   <noscript>
   <?php
   for($i=0;$i<=10;$i++)
    {
    echo '<div class="condition"><select name="field'.$i.'"><option value="0">'.L_NUMBER.'</option><option value="1">'.L_DATE.'/'.L_TIME.'</option><option value="2">'.L_IP.'</option><option value="3">'.L_MODULES_FILE_S.'</option><option value="4">'.L_USERAGENT.'</option><option value="5x">'.L_MODULES_RESOLUTION_S.' X</option><option value="5y">'.L_MODULES_RESOLUTION_S.' Y</option><option value="7">'.L_MODULES_COLORDEPTH_S.' ('.L_BIT.')</option><option value="6">'.L_MODULES_REFERER_S.'</option></select><select name="operator'.$i.'"><option value="0">'.L_LOGS_SEARCH_CONTAINS.'</option><option value="1">'.L_LOGS_SEARCH_CONTAINS_NOT.'</option><option value="2">'.L_LOGS_SEARCH_UNEQUAL.'</option><option value="3">&lt;</option><option value="4">&lt;=</option><option value="5">=</option><option value="6">&gt;=</option><option value="7">&gt;</option></select><input size="50" name="value'.$i.'" type="text" /></div>';
    }
   ?>
   </noscript>
   </div>  
   <p><a href="nojs.php" onclick="addrow(); return false;"><?php echo L_LOGS_ADD_CONDITION; ?></a></p>
   <input type="submit" name="button" value="<?php echo L_LOGS_SEARCH_SUBMIT; ?>" onclick="this.disabled=true; this.value='<?php echo L_LOGS_SEARCH_WAIT; ?>'; document.getElementById('body').style.cursor='wait'; this.form.submit(); "  />
   <input type="submit" name="button" value="<?php echo L_CANCEL; ?>" />
   <input type="hidden" name="<?php echo htmlspecialchars(session_name()); ?>" value="<?php echo htmlspecialchars(session_id()); ?>" />
  </form>
 </body>
</html>