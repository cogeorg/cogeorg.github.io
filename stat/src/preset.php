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

*** src/preset.php ***
Funktion:    bietet preset()-Funktion zum Umgang (einlesen/checken/etc) mit $config_preset-Arrays
Aufrufbar:   nein
Eingebunden: von src/analyze.php, src/show_stat.php (include)
*/

function load_presets()
 {
 global $config_preset, $config_stat_tree, $config_stat_scroll;
 $dir_handle=opendir('../usr/presets');
 $preset_files=array();
 while(false !== ($file=readdir($dir_handle)))
  {
  if(is_file('../usr/presets/'.$file) && $file[0]!='.')
   {                   
   $preset_files[]=$file;
   }
  }
 closedir($dir_handle);
 natsort($preset_files);
 foreach($preset_files as $file)
  {
  include_once('../usr/presets/'.$file);
  }
 }

load_presets();

function preset($preset_id,$overwrite=true, $check_only=false, $correct_time_overflow=false)
 {
 /*
 This function iterates through a $config_preset-Array and does different things:
 - (normally) loads the given preset
   (this is triggered via the preset-selection-box)
 - if $overwrite is false, do not overwrite existing settings!
   (this is used to always load the default-preset without overwriting changed settings)
 - if $check_only is true, only check whether the settings for IP and time are currently set
   (this is used for DFC/PFC)
 - if $correct_time_overflow is true, clear data that was cached but is no longer within
   timespan.
 */
 #echo "<b>$preset_id | overwrite=".($overwrite?1:0)." | check_only=".($check_only?1:0)." | correct_time_overflow=".($correct_time_overflow?1:0)." </b><br />";
 global $list_modules,$list_modules_limit,$list_modules_diagram,$list_modules_calendar,$config_preset,$changed;
 $analyze_settings=array('ip','time_start','time_end','time_span','time_rel','time_rel_start','time_rel_end');
 $preset_data=$config_preset[$preset_id];
 // load presets which this preset is based on
 if(!empty($preset_data['presets']))
  foreach($preset_data['presets'] as $load_preset)
   {
   if($check_only && !preset($load_preset,$overwrite,$check_only)) return false;
   elseif(!$check_only) preset($load_preset,$overwrite,$check_only,$correct_time_overflow);
   }
 // set module-specific settings
 if(!empty($preset_data['modules']))
  {
  foreach($preset_data['modules'] as $modul=>$module_data)
   {
   $global=false;
   switch($modul)
    {
    case 'ALL': $set_modules=$list_modules; break;
    case 'LIMIT': $set_modules=$list_modules_limit; break;
    case 'CHARTS': $set_modules=$list_modules_diagram; break;
    case 'CALENDAR': $set_modules=$list_modules_calendar; break;
    case 'GLOBAL': $global=true; break;
    default:  $set_modules=array($modul);
    }
   // now we know for which modules the settings are meant
   if(!$global)
    {
    foreach($set_modules as $set_module)
     {
     $mod_isrel=(isset($_SESSION['set_'.$set_module.'_time_rel']) && $_SESSION['set_'.$set_module.'_time_rel']);
     // if $correct_time_overflow is true, check and clear (if outdated) cache data
     if(!$check_only && $correct_time_overflow && $mod_isrel && isset($module_data['time_rel_start']))
      {
      $check_start=parse_str_to_time($module_data['time_rel_start']);
      foreach($_SESSION['module_'.$set_module.'_data_timestamps'] as $mod_value=>$check_timestamps) // iterate all values
       {
       foreach($check_timestamps as $check_timestamp_id=>$check_timestamp) // iterate all timestamps for this value
        {
        if($check_timestamp<$check_start) // this timestamp is not within range anymore
         {
         // delete this timestamp and decrease this value by one
         unset($_SESSION['module_'.$set_module.'_data_timestamps'][$mod_value][$check_timestamp_id]);
         $_SESSION['module_'.$set_module.'_data'][$mod_value]--;
         // if the value is <=0, delete the entry if the module supports "limit" 
         if($_SESSION['module_'.$set_module.'_data'][$mod_value]<1 && in_array($set_module,$list_modules_limit))
          {
          unset($_SESSION['module_'.$set_module.'_data'][$mod_value]);
          } 
         }
        }
       }
      }
     else
      {
      foreach($module_data as $setting => $value)
       {
       // first convert "GNU times" (such as "today") into timestamps
       if(($setting=='time_start' || $setting=='time_end') && is_string($value)) $value=strtotime($value);
       // here the actual action is performed
       // normally: set the setting to the new value
       if(!$check_only && !$correct_time_overflow && ($overwrite || !isset($_SESSION['set_'.$set_module.'_'.$setting])) && $_SESSION['set_'.$set_module.'_'.$setting]!==$value)
        {
        if(in_array($setting,$analyze_settings) && $_SESSION['set_'.$set_module.'_'.$setting]!=$value) $changed[$set_module]=true;
        $_SESSION['set_'.$set_module.'_'.$setting]=$value;
        }
       // if $check_only assure that the setting is correct or return false 
       elseif($check_only && !$correct_time_overflow && in_array($setting,$analyze_settings) && $_SESSION['set_'.$set_module.'_'.$setting]!=$value && (!$mod_isrel || ($setting!='time_end' && $setting!='time_start'))) 
        {
        return false;
        }
       }
      }
     }
    }
   elseif(!$check_only && !$correct_time_overflow) // global setting
    {
    foreach($module_data as $setting => $value)
     {
     if($setting=='tree' && $value=='auto' && isset($_SESSION['ajax']) && $_SESSION['ajax']) $value='ajax';
     elseif($setting=='tree' && $value=='auto') $value='mk';
    
     if($overwrite || !isset($_SESSION[$setting])) $_SESSION[$setting]=$value;
     }
    }
   }
  }
 if($check_only) return true;
 }

 
// check all presets to see which one is active (cache-equivalent) 
function check_which_preset()
 {
 global $config_preset;
 foreach($config_preset as $preset=>$preset_data)
  {
  // check if $preset is active
  if(isset($preset_data['cache']) && $preset_data['cache'] && preset($preset,false,true))
   {
   return $preset;
   }
  }
 return false;
 }
 
// check all presets to see which one has exactly the same module-settings
function check_which_preset_exact($p_modules)
 {
 global $config_preset;
 foreach($config_preset as $check_preset=>$check_settings)
  {
  $different=false;
  foreach($p_modules as $module=>$settings)
   {
   if(!is_array($check_settings['modules'][$module]))
    {
    $different=true;
    break;
    }
   $diff=array_diff_assoc($settings,$check_settings['modules'][$module]);
   if(!empty($diff))
    {
    $different=true;
    break;
    }
   }
  if(!$different) return $check_preset;
  }
 return false; 
 }

// returns all the cache-files that belong to a preset 
function get_cachefiles_for_preset($preset_id)
 {
 $files=array();
 $dir_handle=opendir('../usr/cache');
 while(false !== ($file=readdir($dir_handle)))
  {
  if(is_file('../usr/cache/'.$file) && $file[0]!='.' && preg_match('/^'.preg_quote($preset_id,'/').'_[a-f0-9]{32}\.php(\.gz)?$/', $file))
   {
   $files[]=$file;
   }
  }
 return $files;
 }
 
// deletes all cachfiles for a preset
function delete_cachefiles_for_preset($preset_id)
 {
 $cache_files=get_cachefiles_for_preset($preset_id);
 foreach($cache_files as $cache_file)
  {
  unlink('../usr/cache/'.$cache_file);
  }
 }

// generate a preset-(module)-array with the current settings
function generate_preset()
 {
 global $list_modules;
 $p_modules=array();
 $settings=array('all','ip','piechart','time_rel_start','time_rel_end','time_rel_name','time_start','time_end','time_name','time_span','time_rel','time_rel_startid');
 foreach($list_modules as $modul)
  {
  foreach($settings as $setting)
   {
   if(isset($_SESSION['set_'.$modul.'_'.$setting])) $p_modules[$modul][$setting]=$_SESSION['set_'.$modul.'_'.$setting];
   }
  if(isset($_SESSION['set_'.$modul.'_time_span']) && $_SESSION['set_'.$modul.'_time_span'] && (!isset($_SESSION['set_'.$modul.'_time_rel']) || !$_SESSION['set_'.$modul.'_time_rel'])) $p_modules['ABS_TIME'][]=$modul;
  elseif(isset($_SESSION['set_'.$modul.'_time_span']))
   {
   // this module has a relative or no timespan -> delete absolute settings
   foreach(array('time_start','time_end','time_name') as $setting)
    {
    unset($p_modules[$modul][$setting]);
    }
   if(!$_SESSION['set_'.$modul.'_time_span']) // the module has no timepsan -> delete relative settings
    {
    foreach(array('time_rel_start','time_rel_end','time_rel_name','time_rel_startid') as $setting)
     {
     unset($p_modules[$modul][$setting]);
     }    
    }
   }
  }
  $settings_global=array('tree','scroll');
  foreach($settings_global as $setting)
   {
   if(isset($_SESSION[$setting])) $p_modules['GLOBAL'][$setting]=$_SESSION[$setting];
   }
 return $p_modules;
 }

?>