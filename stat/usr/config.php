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

This is CrazyStat's configuration file. If you want to edit any configuration setting,
this is the right place.

_______ You can look up all configuration settings in doc/config_settings_xx.html ________
The whole documentation of config-settings has moved there.
PLEASE HAVE A LOOK AT doc/config_settings_xx.html BEFORE EDITING THIS FILE!

A lot of settings mentioned there are not included here by default, but you can add any
of them here if you want to adjust them.

If you're using Windows Notepad or any editor that has automatic line break, please
disable it now so you do not break this file.

After changing some of the settings, you need to clean the cache.

For more information, see:
- doc/config_settings_xx.html
- doc/README_xx.html
- http://www.christosoft.de


<!--
*/

// +++++ General settings +++++

$config_rel_path="stat/"; // Path to CrazyStat
$config_xhtml=false; // CrazyStat included in XHTML?
$config_ip_anonymous=false; // anonymize IPs? (data privacy)

// +++++ Statistic settings +++++

$config_stat_lang="en"; // Language (de/en/nl?)
$config_stat_weekdays_sunday_first=false; // Sunday first day of the week?
$config_stat_timezone="Europe/Berlin"; // Timezone

// +++++ Counter settings +++++

$config_counter_enabled=false; // Enable counter?
$config_counter_text=false; // Use textcounter?
$config_counter_file_name="ch_nicefont_wb.png"; // Counter-grafic
$config_counter_digits=6; // digits of the counter
$config_counter_transparency=false; // Enable transparency for counter?


?>