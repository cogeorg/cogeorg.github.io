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

------------------------------------------------------------------------------------------

Attention! DO  NOT EDIT THIS FILE, EDIT usr/config.php INSTEAD!!!!

This is CrazyStat's default configuration file.
These settings are used if there is no such setting in usr/config.php.

*/

$config_rel_path="stat/";
$config_different_rel_paths=false;
$config_logfile_folder="logs";
$config_logfile_name="stat.log";
$config_logfile_maxsize=1000;
$config_log_zlib=true;
$config_count_file="counter.log";
$config_alt_text="";
$config_ip_block_time=30;
$config_ip_anonymous=false;
$config_salt_str="SomeRand0m_strlng";
$config_xhtml=false;
$config_xhtml_noscript=true;
$config_xhtml_old=false;
$config_stat_lang="en";
$config_stat_password_protect=true;
$config_stat_user=array ('admin' => '1a1dc91c907325c69271ddf0c944bc72',);
$config_stat_password_md5=true;
$config_stat_cache=true;
$config_stat_preset_file_cache=true;
$config_stat_pfc_zlib=true;
$config_stat_long_bars=true;
$config_stat_bar_length=100;
$config_stat_pie_colors=array("#5151FF","#FF4242","#4FFF4F","#FFFF4F","#DBDBDB","#FF7DFF","#FFB56A","#6A6AFF","#565656","#408080","#FF00FF");
$config_stat_limit["file"]=10;
$config_stat_files_hide_dir=true;
$config_stat_files_maxlength=30;
$config_stat_files_delete=array("");
$config_stat_files_replace=array();
$config_stat_files_preg_replace=array();
$config_stat_limit["resolution"]=4;
$config_stat_limit["colordepth"]=3;
$config_stat_colordepth_unsaved=false;
$config_stat_limit["browser"]=4;
$config_stat_limit["system"]=4;
$config_stat_limit["referer"]=3;
$config_stat_referer_empty=false;
$config_stat_referer_ignore=array();
$config_stat_referer_replace=array();
$config_stat_tree="auto";
$config_stat_referer_tree=true;
$config_stat_limit["keyword"]=3;
$config_stat_user_online=15;
$config_stat_max_style="font-weight: bold";
$config_stat_log_rows=40;
$config_stat_scroll=true;
$config_stat_pie_size=89;
$config_stat_weekdays_sunday_first=false;
$config_stat_timezone="Europe/Berlin";
$config_stat_ajax=true;
$config_stat_ext_lytebox=true;
$config_stat_overlay=true;
$config_stat_calendar_autorel=false;
$config_stat_default_preset="01_default";
$config_stat_guest_log_delete=false;
$config_stat_guest_log_download=false;
$config_stat_guest_preset_manage=false;
$config_stat_guest_cache_delete=false;
$config_stat_lang_fix=false;
$config_stat_user_log_delete=true;
$config_stat_user_log_download=true;
$config_stat_user_preset_manage=true;
$config_stat_user_cache_delete=true;
$config_stat_memory_limit=128;
$config_counter_enabled=true;
$config_counter_text=false;
$config_counter_alternative=false;
$config_counter_folder="counter_styles";
$config_counter_file_name="ch_nicefont_wb.png";
$config_counter_digits=6;
$config_counter_transparency=false;
$config_counter_reload=true;
$config_counter_add=0;
$config_counter_link="%CRAZYSTATPATH%src/index.php";
$config_counter_link_target="_blank";
$config_counter_cookie_text="Cookie";
$config_counter_reload_show=false;
$config_counter_reload_show_text="R";
$config_counter_reload_show_pos["x"]=1/14;
$config_counter_reload_show_pos["y"]=4/5;
$config_counter_reload_show_size=1;
$config_counter_reload_show_col["r"]=255;
$config_counter_reload_show_col["g"]=0;
$config_counter_reload_show_col["b"]=0;
$config_counter_reload_show_back=true;
$config_counter_reload_show_back_col["r"]=255;
$config_counter_reload_show_back_col["g"]=255;
$config_counter_reload_show_back_col["b"]=255;
?>