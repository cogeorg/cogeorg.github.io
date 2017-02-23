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

*** src/pie_map.php ***
Function:                        generate imagemap for piecharts
Meant to be opened in browser:   no
Included:                        by src/module_out.php, src/pie_zoom.php
*/

function pie_map($module,$link,$size)
 {
 $imagemap='';
 if(is_array($_SESSION['module_'.$module.'_data']) && count($_SESSION['module_'.$module.'_data'])>0)
  {
  $imagemap='<map name="map_'.$module.'" id="map_'.$module.'">';
  $mid_coord=round(($size)/2);
  $old_x=$mid_coord;
  $old_y=0;
  $angle=270;
  arsort($_SESSION['module_'.$module.'_data']);
  foreach($_SESSION['module_'.$module.'_data'] as $entry => $nr)
   {
   $imagemap.='<area '.$link.' shape="poly" coords="'.$mid_coord.','.$mid_coord.','.$old_x.','.$old_y;
   $percentage=prozent($nr,$_SESSION['module_'.$module.'_total']);
   for($angle_new=$angle+round(($percentage/100)*360); $angle<=$angle_new; $angle+=15)
    {
    $new_x=round(floor(($size-2)/2)*cos($angle/180*M_PI)+round(($size)/2));
    $new_y=round(floor(($size-2)/2)*sin($angle/180*M_PI)+round(($size)/2));
    $imagemap.=','.$new_x.','.$new_y;
    if($angle_new!=$angle && $angle+15>$angle_new) $angle=$angle_new-15;
    }
   $angle=$angle_new;
   $imagemap.='" title="'.htmlentities($entry).' - '.$percentage.'% ('.$nr.')" alt="'.L_MODULEOUT_PIE_CHART.' '.$module.'" />';
   $old_x=$new_x;
   $old_y=$new_y;
   }
  $imagemap.='</map>';
  }
 return $imagemap;
 }

?>