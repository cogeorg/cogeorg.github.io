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

E-Mail: webmaster AT christosoft.de
Web: http://www.christosoft.de
Version: 1.70


*** src/pie_zoom.php ***
Funktion:    Kreisdiagramm vergrossert darstellen
Aufrufbar:   nein
Eingebunden: von src/show_stat.php (Link)
*/
require_once('general_include.php');
require_once('pie_map.php');


if(empty($_GET['modul']) || !in_array($_GET['modul'],$list_modules_diagram)) $modul='browser';
else $modul=$_GET['modul'];

header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>CrazyStat - <?php echo L_MODULEOUT_PIE_CHART.' '.constant('L_MODULES_'.strtoupper($modul).'_P'); ?></title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <?php if(is_file('extensions/sortabletable.js')) { ?>
  <script type="text/javascript" src="extensions/sortabletable.js"></script>
  <?php } ?>
  <meta name="generator" content="CrazyStat" />
 </head>
 <body>
 <?php
 $link='href="nojs.php" onclick="'.($config_stat_ext_lytebox?'parent.myLytebox.end();':'window.close(); return false;').'"';
 echo pie_map($modul, $link,360);
 ?>
 <a <?php echo $link; ?>><img src="piechart.php?<?php echo SIDX.'&amp;modul='.$modul; ?>&amp;size=360" width="360" height="360" align="left" style="margin:20px" alt="<?php echo L_MODULEOUT_PIE_CHART.' '.constant('L_MODULES_'.strtoupper($modul).'_P'); ?>" usemap="#map_<?php echo $modul; ?>" /></a>
 <div style="width: 260px; height: 380px; overflow:auto;">
 <table width="100%" id="daten_tabelle">
 <thead><tr><th><?php echo constant('L_MODULES_'.strtoupper($modul).'_S'); ?></th><th><?php echo L_MODULEOUT_NUM; ?></th><th><?php echo L_MODULEOUT_PER; ?></th></tr></thead>
 <tfoot><tr class="gesamt"><td><?php echo L_MODULEOUT_TOTAL; ?></td><td><?php echo $_SESSION['module_'.$modul.'_total']; ?></td><td></td></tr></tfoot>
 <tbody>
 <?php
 if(!isset($_SESSION['module_'.$modul.'_data'])) die(L_MSG_ERR.': '.L_PIEZOOM_MSG_ERR_NO_DATA.'</table></body></html>');
 $farben=$config_stat_pie_colors;
 $grauton=0;
 $i=0;
 arsort($_SESSION['module_'.$modul.'_data']);   
 foreach($_SESSION['module_'.$modul.'_data'] as $eintrag=>$anzahl)
  {
  if(!isset($farben[$i]))
   {
   $grauton+=20;
   if($grauton>255) $grauton=0;
   $farben[$i]="rgb(".$grauton.",".$grauton.",".$grauton.")";
   }
  $prozent=prozent($anzahl,$_SESSION['module_'.$modul.'_total']);
  if($modul=='colordepth')
   {
   $eintrag='<span title="'.pow(2,$eintrag).' '.L_MODULEOUT_COLORS.'">'.prettyInt(pow(2,$eintrag)). ' '.L_MODULEOUT_COLORS.' ('.htmlentities($eintrag).' '.L_BIT.')</span>';
   }
  else $eintrag=htmlentities($eintrag);
  echo '<tr><td><span style="background-color:'.$farben[$i].';">&nbsp;&nbsp;</span>&nbsp;'.$eintrag.'</td>';
  echo '<td>'.$anzahl.'</td><td>'.$prozent.'%</td></tr>'."\n    ";
  $i++;
  }
 echo '</tbody>';

 // Prozent-Funktion
 function prozent($teil, $gesamt)
  {
  return @round($teil/$gesamt*100);
  }
 
 ?>
 </table>
 <?php if(is_file('extensions/sortabletable.js')) { ?>
 <script type="text/javascript">
 var t=new SortableTable(document.getElementById('daten_tabelle'), 100);
 </script>
 <?php } ?>
 </div>
 </body>
</html>