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

*** log_funcs.php ***
Function:                        Offers functions to handle logfiles
Meant to be opened in browser:   no
Included:                        by stat.php, show_log.php, show_stat.php (require_once)
*/

 
function get_last_log($path='')
 {
 global $config_logfile_maxsize,$neue_datei, $log_file_number, $config_log_zlib;
 $name=split_log_name();
 $ext=$name['ext'];
 $name=$name['name'];
 $i=0;
 $neue_datei=false;
 while(is_file($path.$name.$i.$ext) || is_file($path.$name.$i.$ext.'.gz'))
  {
  $i++;
  }
 $i--;
 @$log_size=filesize($path.$name.$i.$ext)/1000;
 if(!is_dir(dirname($path.$name))) return false;
 if($i==-1 || ($config_logfile_maxsize!==false && $log_size>=$config_logfile_maxsize))     // neue Datei anlegen
  {
  if(function_exists('stream_get_wrappers') && $config_log_zlib && in_array('compress.zlib', stream_get_wrappers()))
   {
   // compress old file
   $fh_compressed=fopen('compress.zlib://'.$path.$name.$i.$ext.'.gz','w');
   fwrite($fh_compressed,file_get_contents($path.$name.$i.$ext));
   fclose($fh_compressed);
   unlink($path.$name.$i.$ext);
   }
  $i++;
  $neue_log=fopen($path.$name.$i.$ext,'w');
  fclose($neue_log);
  $neue_datei=true;
  }
 $log_file_number=$i;
 return $path.$name.$i.$ext;
 }
 
function get_first_log()
 {
 global $log_file_number;
 $name=split_log_name();
 $ext=$name['ext'];
 $name=$name['name'];

 $name=$name.'0'.$ext;
 if(!is_file($name) && !is_file($name.'.gz'))
  {
  @$neue_log=fopen($name,'w');
  @fclose($neue_log);
  }
 $log_file_number=0;
 return $name;
 }
 
function get_next_line()
 {
 global $handle, $logdatei_name, $log_file_number;
 if(feof($handle))                        // naechste Datei oeffnen
  {
  $name=split_log_name();
  $ext=$name['ext'];
  $name=$name['name'];
  $i=$log_file_number+1;
  if(is_file($name.$i.$ext) || is_file($name.$i.$ext.'.gz'))
   {
   $log_file_number=$i;
   $logdatei_name=$name.$i.$ext;
   $handle=open_logfile($name.$i.$ext,'r');
   $zeile=trim(fgets($handle));
   }
  else return false;
  }
 else
  {
  $zeile=trim(fgets($handle));
  if(empty($zeile)) $zeile=get_next_line();
  }
 return $zeile;
 }

function split_log_name()
 {
 global $config_logfile_folder,$config_logfile_name;
 $name_t='../usr/'.$config_logfile_folder.'/'.$config_logfile_name;
 $name['name']=substr($name_t,0,strrpos($name_t,'.'));
 $name['ext']=substr($name_t,strrpos($name_t,'.'));
 return $name;
 }
 
function open_logfile($filename,$mode)
 {
 if(is_file($filename.'.gz')) $fh=fopen('compress.zlib://'.$filename.'.gz',$mode);
 elseif(is_file($filename)) $fh=fopen($filename,$mode);
 else $fh=false;
 return $fh;
 }
 

?>