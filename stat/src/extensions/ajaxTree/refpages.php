<?php
/*
Diese Datei ist Teil einer Extension für:

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

*** refpages.php ***
Funktion:    Referer-Infos an AJAXTree rücklieferen
Aufrufbar:   (ja)
Eingebunden: von ajaxTree.js (per AJAX angefordert)
*/

session_start();

if(isset($_GET['id']) && is_numeric($_GET['id']) && is_array($_SESSION['module_referer_keys']))
 {
 $node=$_SESSION['module_referer_keys'][$_GET['id']];

 if(isset($_SESSION['module_referer_hosts'][$node]))
  {
  arsort($_SESSION['module_referer_hosts'][$node]);
  foreach($_SESSION['module_referer_hosts'][$node] as $eintrag=>$wert)
   {
   echo utf8_encode(str_replace('@','%40',$eintrag)).'@'.$wert."\n";
   }
  }
 else echo 'Keine Daten oder Fehler@0';
 }
else echo 'Keine Daten oder Fehler@0';

?>