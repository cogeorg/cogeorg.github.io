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

*** src/module_out.php ***
Funktion:    gibt Ergebnisse der auswertung für ein Modul aus
Aufrufbar:   nein
Eingebunden: von src/show_stat.php (include), src/module_refresh.js (ajax)
*/

$noForm=true;
require_once('general_include.php');
require_once('pie_map.php');

// ajax refresh
if(isset($_GET['modul']) && in_array($_GET['modul'],$list_modules))
 {
 $ajaxRefresh=true;
 header('Content-Type: text/html; charset=UTF-8');
 $modul=$_GET['modul'];

 if($modul=='referer' && isset($_GET['js_data']))
  {
  die(json_encode($_SESSION['ajax_tree_js_data']));
  }
 
 if(isset($_GET['mode']))
  {
  switch($_GET['mode'])
   {
   case 'refresh':         $changed[$modul]=true; break;
   case 'all':             $_SESSION['set_'.$modul.'_all']=true; break;
   case 'limit':           $_SESSION['set_'.$modul.'_all']=false; break;
   case 'ip1':             $_SESSION['set_'.$modul.'_ip']=true; $changed[$modul]=true; break;
   case 'ip0':             $_SESSION['set_'.$modul.'_ip']=false; $changed[$modul]=true; break;
   case 'diagramm0':       $_SESSION['set_'.$modul.'_piechart']=false; break;
   case 'diagramm1':       $_SESSION['set_'.$modul.'_piechart']=true; break;
   case 'referer_tree0':   $_SESSION['tree']=false; break;
   case 'referer_tree_mk': $_SESSION['tree']='mk'; break;
   case 'referer_tree_ajax': $_SESSION['tree']='ajax'; break;   
   }
  }
 include_once('analyze.php');
 if($_SESSION['tree']=='ajax' && !is_file('extensions/ajaxTree/ajaxTree.js')) $_SESSION['tree']=false;
 module_out($_GET['modul']);
 }
else $ajaxRefresh=false;

// Print module-data
function module_out($modul)
 {
 global $list_modules_limit, $list_modules_diagram, $config_stat_max_style, $config_stat_limit, $config_stat_pie_colors, $config_stat_referer_ignore, $config_stat_long_bars, $config_stat_scroll_middle, $config_stat_scroll_right, $config_stat_files_maxlength, $config_stat_bar_length, $config_stat_pie_size, $config_stat_files_hide_dir, $config_stat_ext_lytebox, $ajaxRefresh;

 $module_werte = $_SESSION['module_'.$modul.'_data'];
 $gesamt = $_SESSION['module_'.$modul.'_total'];
 $max = $_SESSION['module_'.$modul.'_max'];
 $max_name = $_SESSION['module_'.$modul.'_max_name'];
 $name = constant('L_MODULES_'.strtoupper($modul).'_S');
 $name_p = constant('L_MODULES_'.strtoupper($modul).'_P');
 
  
 echo '   <!-- Start Modul '.ucfirst($modul).' -->'."\n";
 if(!isset($_GET['modul'])) echo '   <div id="module_'.$modul.'">';
 
 if($modul=='hit')
  {
  ?>
    <table class="modul">
     <thead>
      <tr><th colspan="2" class="modul"><a href="show_stat.php?<?php echo SIDX; ?>&amp;changed=hit" onclick="return refresh('hit','mode=refresh');"><img src="img/refresh.png" align="right" title="<?php echo L_MODULEOUT_CONSOLE_REFERSH; ?>" alt="<?php echo L_MODULEOUT_CONSOLE_REFERSH_ALT; ?>" width="16" height="16" /></a><?php echo L_MODULES_HIT_P; ?></th></tr>
     </thead>
     <tbody>
      <tr><td><?php echo L_MODULEOUT_HITS_PI; ?>:</td><td><?php echo $module_werte['gesamt']; ?></td></tr>
      <tr><td><?php echo L_MODULEOUT_HITS_VISITS; ?>:</td><td><?php echo $module_werte['gesamt_ip']; ?></td></tr>
      <tr><td><?php echo L_MODULEOUT_HITS_THIS_MONTH; ?>:</td><td><?php echo $module_werte['diesen_monat']; ?></td></tr>
      <tr><td><?php echo L_MODULEOUT_HITS_LAST_MONTH; ?>:</td><td><?php echo $module_werte['letzten_monat']; ?></td></tr>
      <tr><td><?php echo L_MODULEOUT_HITS_USER_ONLINE; ?>:</td><td><?php echo $module_werte['user_online']; ?></td></tr>
      <tr><td><?php echo L_MODULEOUT_HITS_MAX_DAY; ?> <?php echo @$module_werte['max_tag']; ?>:</td><td><?php echo $module_werte['max']; ?></td></tr>
      <tr><td><?php echo L_MODULEOUT_HITS_AV_PER_DAY; ?></td><td><?php echo @$module_werte['durchschnitt']; ?></td></tr>
      <tr><td><?php echo L_MODULEOUT_HITS_HITS_PER_USER; ?></td><td><?php echo $module_werte['proUser']; ?></td></tr>
     </tbody>
    </table>
  <?php
  }
 else
  {
  
  if(!isset($config_stat_limit[$modul]) || $config_stat_limit[$modul]!=0)
   {
   if(in_array($modul,$list_modules_limit))
    {
    if(!isset($module_werte) || !is_array($module_werte) || count($module_werte)<1) $module_werte=array(L_MODULEOUT_NO_DATA => 0);
    else arsort($module_werte);
    }
 
 
   if($_SESSION['set_'.$modul.'_time_span'])
    {
    if(!empty($_SESSION['set_'.$modul.'_time_name'])) $zeitabschnitt=$_SESSION['set_'.$modul.'_time_name'];
    else
     {
     $zeitabschnitt_start=date(L_DATE_FORMAT,$_SESSION['set_'.$modul.'_time_start']);
     $zeitabschnitt_ende=date(L_DATE_FORMAT,$_SESSION['set_'.$modul.'_time_end']);
     $zeitabschnitt=$zeitabschnitt_start.'-'.$zeitabschnitt_ende;
     }
    }
   else $zeitabschnitt=L_MODULEOUT_TOTAL_TIME;
 
   echo '   <table class="modul">';
   echo "\n".'    <tr><th colspan="2" class="modul">'.konsole($modul).($_SESSION['set_'.$modul.'_ip']?L_VISITS:L_PAGEIMPRESSIONS).'/'.$name.' <span class="spanne">('.$zeitabschnitt.")</span></th></tr>\n   ";
   
   // ______________________Pie Chart______________________
   if(in_array($modul,$list_modules_diagram) && $_SESSION['set_'.$modul.'_piechart'])
    {
    $link='href="pie_zoom.php?'.SIDX.'&amp;modul='.$modul.'&amp;" '.($config_stat_ext_lytebox?'rel="lyteframe" rev="width: 700px; height: 420px; scrolling: no;"':"onclick=\"kreis_zoom=window.open('pie_zoom.php?".SIDX."&amp;modul=".$modul."','kreis_zoom','height=420, width=700'); kreis_zoom.focus(); return false;\"").' target="_blank"';
    $link_map='href="pie_zoom.php?'.SIDX.'&amp;modul='.$modul.'&amp;" '.($config_stat_ext_lytebox?'target="lyteframe" ':"onclick=\"kreis_zoom=window.open('pie_zoom.php?".SIDX."&amp;modul=".$modul."','kreis_zoom','height=420, width=700'); kreis_zoom.focus(); return false;\"");
    ?>
    <tr>
     <td><a <?php echo $link.'title="'.L_MODULEOUT_PIE_CHART.' '.$name_p.'"'; ?>><img src='piechart.php?<?php echo SIDX; ?>&amp;modul=<?php echo $modul; ?>' id="kreisdiagramm_<?php echo $modul; ?>" alt="<?php echo L_MODULEOUT_PIE_CHART.' '.$name; ?>" width="<?php echo $config_stat_pie_size; ?>" height="<?php echo $config_stat_pie_size; ?>" usemap="#map_<?php echo $modul; ?>" /></a></td>
     <td>
     <?php
     echo pie_map($modul,$link_map,$config_stat_pie_size);
    
     if($_SESSION['scroll'] && in_array($modul, $list_modules_limit))
      {
      echo '<div style="width:180px; height:1px;"></div>'; // Minwidth-ersatz
      if($modul=='browser') { $h=113; $w=$config_stat_scroll_middle-100; }
      else { $h=113; $w=$config_stat_scroll_right-100; }
      echo '<div class="daten" '.($_SESSION['set_'.$modul.'_all']?'style="height:'.$h.'px;"':'').'>';
      }
     ?>
      <table class="daten" id="daten_<?php echo $modul; ?>">
       <thead><tr><th title="<?php echo L_MODULEOUT_SORT_BY.' '.$name; ?>"><?php echo $name; ?></th><th title="<?php echo L_MODULEOUT_SORT_BY_NUM; ?>"><?php echo L_MODULEOUT_NUM; ?></th><th title="<?php echo L_MODULEOUT_SORT_BY_PER; ?>"><?php echo L_MODULEOUT_PER; ?></th></tr></thead>
       <tfoot>
        <tr class="gesamt"><td><?php echo L_MODULEOUT_TOTAL; ?></td><td><?php echo $gesamt; ?></td><td>(&#248; <?php echo average($gesamt,$module_werte); ?>)</td></tr>
       </tfoot>  
       <tbody>
       <?php
       $farben=$config_stat_pie_colors;
       $grauton=0;
       $i=0;
       foreach($module_werte as $eintrag => $anzahl)
        {
        $prozent=prozent($anzahl,$gesamt);
        if($_SESSION['set_'.$modul.'_all'] || $i<$config_stat_limit[$modul])
         {
         if(!isset($farben[$i]))
          {
          $grauton+=20;
          if($grauton>255) $grauton=0;
          $farben[$i]='rgb('.$grauton.','.$grauton.','.$grauton.')';
          }
         echo '<tr><td><span style="background-color:'.$farben[$i].';">&nbsp;&nbsp;</span>&nbsp;'.htmlentities($eintrag).'</td><td>'.$anzahl.'</td><td>'.$prozent.' %</td></tr>';
         $i++;
         }
        elseif($prozent<2) break;
        }
       ?>
       </tbody>
      </table>
     <?php
     if($_SESSION['scroll'] && in_array($modul, $list_modules_limit)) echo '</div>';
     ?>
 
     </td>
    </tr>
    <?php
    }
   // ______________________Baumdarstellung der referer______________________
   elseif($modul=='referer' && $_SESSION['tree']!==false)
    {
    // Referer zusammenfassen
    $referer2=$module_werte;
    unset($module_werte);
    foreach($referer2 as $referer=>$anzahl)
     {
     $url_info=parse_url($referer);
     if(!isset($url_info['host'])) $url_info['host']='';
     $referer=str_replace((empty($url_info['scheme'])?'':$url_info['scheme'].'://'.$url_info['host']),'',$referer);
     $module_werte[$url_info['host']][$referer]=$anzahl;
     }
    // Array mit Anzahl hits pro Host erstellen
    $gesamt_hosts=0;
    $max_referer_hosts=0;
 
    
    if(isset($module_werte)) foreach($module_werte as $eintrag=>$wert)
     {
     if(is_array($wert))
      {
      $hostanz_array[$eintrag]=0;
      foreach($wert as $wert2) $hostanz_array[$eintrag]+=$wert2;
      @$gesamt_hosts+=$hostanz_array[$eintrag];
      if($config_stat_long_bars && $hostanz_array[$eintrag]>$max_referer_hosts) $max_referer_hosts=$hostanz_array[$eintrag];
      }
     }
    @arsort($hostanz_array);
 
 
    if($_SESSION['tree']=='mk')  //  mit plugin mktree
     {
     echo ' <tr><th colspan="2">'.$name.'<span class="ref130">'.L_MODULEOUT_NUM.'</span><span style="position:absolute; right:510px">'.L_MODULEOUT_RATIO.'</span></th></tr><tr><td colspan="2"><ul class="mktree" id="tree1">';
 
     // Hosts durchgehen
     $i=0;
     if(isset($hostanz_array)) foreach($hostanz_array as $eintrag=>$hostanz)
      {
      $wert=$module_werte;
      $wert=$wert[$eintrag];
      // Ausgabe
      if(!isset($config_stat_limit[$modul]) || ((!$_SESSION['set_'.$modul.'_all'] && $i<$config_stat_limit[$modul]) || $_SESSION['set_'.$modul.'_all']))
       {
       echo '<li>';
       $prozent=prozent($hostanz,$gesamt_hosts);
       
       if($config_stat_long_bars && isset($max_referer_hosts)) $prozent2=round(prozent($hostanz,$max_referer_hosts)/100*$config_stat_bar_length);
       else $prozent2=round($prozent/100*$config_stat_bar_length);
       $rest=$config_stat_bar_length-$prozent2;
       if(is_string($eintrag)) echo $eintrag;  // Hostname ausgeben
       if(is_array($wert))                     // einzelne Referer durchgehen
        {
        echo '<span class="ref130">'.$hostanz.'</span><span class="ref20"><img src="img/bar1.gif" height="10" width="'.$prozent2.'" title="'.$prozent.'%" alt="'.$prozent.'%" /><img src="img/bar0.gif" height="10" width="'.$rest.'" title="'.$prozent.'%" alt="" /></span>'; // Anzahl Hits  und Balken des Host
        echo '<ul>';
        arsort($wert);
        foreach($wert as $eintrag2=>$wert2)    // Einzelne Referer des hosts durchgehen
         {
         if(strlen($eintrag2)>100)            // kuerzen?
          {
          $eintrag2_ungekuertzt=$eintrag2;
          $eintrag2=substr($eintrag2,0,100)."[...]";
          }
         else $eintrag2_ungekuertzt=$eintrag2;
         $eintrag2='<a href=\''.linkprep('http://'.$eintrag.$eintrag2_ungekuertzt).'\' class="referer" target="_blank">'.htmlentities($eintrag2).'</a>'."\n";
         echo '<li>'.$eintrag2;   // einzelnen referer ausgeben
         if(is_int($wert2))
          {
          $prozent=prozent($wert2,$gesamt_hosts);
          if($config_stat_long_bars && isset($max)) $prozent2=round(prozent($wert2,$max)/100*$config_stat_bar_length);
          else $prozent2=round($prozent/100*$config_stat_bar_length);
          $rest=$config_stat_bar_length-$prozent2;
          echo '<span class="ref130">'.$wert2.'</span><span class="ref20"><img src="extensions/lightblue.gif" height="10" width="'.$prozent2.'" title="'.$prozent.'%" alt="'.$prozent.'%" /><img src="img/bar0.gif" height="10" width="'.$rest.'" title="'.$prozent.'%" alt="" /></span>';
          }
         echo '</li>';
         }
        echo '</ul>';
        }
       echo '</li>';
       }
      else break;
      $i++;
      }
     echo '</ul>';
     if(!$ajaxRefresh) echo '<script type="text/javascript">mk=true; ajaxTree=false;</script>';
     echo '<div style="border-top: 1px solid #CACACA;"><span style="margin-left: 20px">'.L_MODULEOUT_TOTAL.'</span><span class="ref130">'.$gesamt.' (&#248; '.average($gesamt,$module_werte).')</span></div>';
     }
    elseif($_SESSION['tree']=='ajax') //mit plugin ajaxTree
     {
     echo ' <tr><td colspan="2">';
     // Speichere Baum-Daten in Session fuer ref_pages.php
     $anz_hosts=count($hostanz_array);
     if(isset($config_stat_limit[$modul]) && $anz_hosts>$config_stat_limit[$modul] && !$_SESSION['set_'.$modul.'_all'])
      {
      $_SESSION['module_referer_hosts']=Array();
      reset($hostanz_array);
      for($i=0;$i<$config_stat_limit[$modul];$i++)
       {
       $_SESSION['module_referer_hosts'][key($hostanz_array)]=$module_werte[key($hostanz_array)];
       next($hostanz_array);
       }
      }    
     else $_SESSION['module_referer_hosts']=$module_werte;
     // Speichere Keys für refpages.php
     @$_SESSION['module_referer_keys']=array_keys($hostanz_array);
 
     if(isset($config_stat_limit[$modul]) && $anz_hosts>$config_stat_limit[$modul] && !$_SESSION['set_'.$modul.'_all']) $anz_hosts=$config_stat_limit[$modul];
     // Uebergebe Daten an JavaScript
     $js_data=Array();
     $js_data['parents']=Array();
     $js_data['laenge']=$config_stat_bar_length;
     $js_data['gesamt']=$gesamt_hosts;
     $js_data['gesamt2']=($config_stat_long_bars && isset($max)?$max:$gesamt);
     $js_data['host_anz']=$anz_hosts;
     $js_data['childs']=Array(0);
     $js_data['sid']=SIDX;
     ?>
     <table style="width:100%" cellpadding="0" cellspacing="0" id="daten_referer">
      <colgroup>
       <col width="10" />
       <col width="*" />
       <col width="50" />
       <col width="110" />
      </colgroup>
      <thead>
       <tr><th colspan="2"><?php echo $name; ?></th><th><?php echo L_MODULEOUT_NUM; ?></th><th><?php echo L_MODULEOUT_RATIO; ?></th></tr>
      </thead>
      <tfoot>
       <?php echo '<tr class="gesamt"><td></td><td>'.L_MODULEOUT_TOTAL.' '.L_MODULEOUT_PAGES.'/'.L_MODULEOUT_DOMAINS.'</td><td>'.$gesamt.'/'.count($hostanz_array).'</td><td>(&#248; '.average($gesamt,$module_werte).')</td></tr>'; ?>
      </tfoot>
      <tbody id="tabelle">
     <?php
     // Hosts durchgehen
     $id=0;
     $js_data['hosts']=array("");
     if(isset($hostanz_array)) foreach($hostanz_array as $eintrag=>$hostanz)
      {
      $id++;
      // Ausgabe
      if(!isset($config_stat_limit[$modul]) || ((!$_SESSION['set_'.$modul.'_all'] && $id<=$config_stat_limit[$modul]) || $_SESSION['set_'.$modul.'_all']))
       {
       $prozent=prozent($hostanz,$gesamt_hosts);
       if($config_stat_long_bars && isset($max_referer_hosts)) $prozent2=round(prozent($hostanz,$max_referer_hosts)/100*$config_stat_bar_length);
       else $prozent2=round($prozent/100*$config_stat_bar_length);
       $rest=$config_stat_bar_length-$prozent2;
       $handle='onclick="menuclick('.$id.'); return false;"';
       $js_data['childs'][]=count($module_werte[$eintrag]);
       $js_data['hosts'][]=$eintrag;
       ?>
 <tr id="row<?php echo $id; ?>" class="ajaxTreeZeile<?php echo $id%2; ?>">
        <td><img src="extensions/ajaxTree/plus<?php if($anz_hosts==1) echo '5'; elseif($id==1) echo '1'; elseif($id==$anz_hosts) echo '3'; else echo '2';  ?>.gif" alt="+" title="" id="pic<?php echo $id; ?>" <?php echo $handle; ?> class="ajaxTreeHand" /></td>
        <td><a href="nojs.php" <?php echo $handle; ?> class="ajaxTreeDomain"><?php echo $eintrag; ?> </a></td>
        <td><?php echo $hostanz; ?></td>
        <td><img src="img/bar1.gif" height="10" width="<?php echo $prozent2; ?>" title="<?php echo $prozent; ?>%" alt="<?php echo $prozent; ?>%"  /><img src="img/bar0.gif" height="10" width="<?php echo $rest; ?>" title="<?php echo $prozent; ?>%" alt=""  /></td>
       </tr>
       <?php
       }
      else break;
      }
     echo '
     </tbody>
     </table>';
     echo '<script type="text/javascript" language="javascript">
          var js_data = '.json_encode($js_data).';
          </script>';
     $_SESSION['ajax_tree_js_data']=$js_data;
     }
    echo '</td></tr>';
    }
   // ______________________Balkendiagramme______________________
   else
    {
    echo ' <tr><td colspan="2">';
    if($_SESSION['scroll'] && in_array($modul, $list_modules_limit) && $modul!='referer' && $modul!='keyword')
     {
     echo '<div style="width:'.($modul=='browser'?240:300).'px; height:1px"></div>';  // Minwidth-ersatz
     if($modul=='browser') $h=113;
     elseif($modul=='file') $h=220;
     elseif($modul=='colordepth') $h=95;
     else $h=102;
     echo '<div style="'.($_SESSION['set_'.$modul.'_all']?'height:'.$h.'px; overflow:auto; ':'').'width:100%;">';
     }
    echo '<table class="daten" id="daten_'.$modul.'"><thead><tr><th title="'.L_MODULEOUT_SORT_BY.' '.$name.'">'.$name.'</th><th title="'.L_MODULEOUT_SORT_BY_NUM.'">'.($modul=='day'?L_MODULEOUT_NUM_ABR:L_MODULEOUT_NUM).'</th><th title="'.L_MODULEOUT_SORT_BY_RATIO.'">'.L_MODULEOUT_RATIO.'</th></tr></thead>
          <tfoot><tr class="gesamt"><td>'.L_MODULEOUT_TOTAL.'</td><td>'.$gesamt.'</td><td>(&#248; '.average($gesamt,$module_werte).')</td></tr></tfoot>
          <tbody>';
    if($modul=='weekday')
     {
     if(!$config_stat_weekdays_sunday_first && isset($module_werte[0]))
      {
      $module_werte[7]=$module_werte[0];
      unset($module_werte[0]);
      }
     $tag_namen=explode(' ',L_CALENDAR_WEEKDAYS);
     $tag_namen[]=$tag_namen[0];
     }
    $i=0;
    if(isset($module_werte))
     {
     reset($module_werte);
     if(isset($_SESSION['set_'.$modul.'_time_rel_startid']))
      {
      $startid=calc_start_id($_SESSION['set_'.$modul.'_time_rel_startid']);
      for($goid=1;$goid<$startid;$goid++) next($module_werte);
      }
     for($togo=count($module_werte); $togo>0; $togo--)  
      {
      if(current($module_werte)===false)
       {
       reset($module_werte); // start from the beginning
       $separate=true;
       }
      else $separate=false;
      list($eintrag, $anzahl) = each($module_werte);
      if(!isset($config_stat_limit[$modul]) || ($_SESSION['set_'.$modul.'_all'] || $i<$config_stat_limit[$modul]))
       {
       $prozent=prozent($anzahl,$gesamt);
       if($config_stat_long_bars && isset($max)) $prozent2=round(prozent($anzahl,$max)/100*$config_stat_bar_length);
       else $prozent2=round($prozent/100*$config_stat_bar_length);
       $rest=$config_stat_bar_length-$prozent2;
       if(isset($max_name) && $eintrag==$max_name && !in_array($modul,$list_modules_limit)) $markiere=" class='max'"; else $markiere='';
       if($modul=='file')
        {
        $eintrag=urldecode($eintrag);
        $eintrag_ungekuertzt=$eintrag;
        if(!isset($config_stat_files_hide_dir) || $config_stat_files_hide_dir) $eintrag=basename($eintrag);
        if($eintrag_ungekuertzt[strlen($eintrag_ungekuertzt)-1]=='/') $eintrag.='/';
        if(strlen($eintrag)>$config_stat_files_maxlength) $eintrag=substr($eintrag,0,$config_stat_files_maxlength-2).'[...]';
        $eintrag=htmlentities($eintrag);
        }
       elseif($modul=='colordepth')
        {
        $eintrag='<span title="'.pow(2,$eintrag).' '.L_MODULEOUT_COLORS.'">'.prettyInt(pow(2,$eintrag)). ' '.L_MODULEOUT_COLORS.' ('.$eintrag.' '.L_BIT.')</span>';
        }
       elseif($modul=='keyword' && isset($_SESSION['module_keyword_orig'][$eintrag]))
        {
        $eintrag=$_SESSION['module_keyword_orig'][$eintrag];
        }
       if($modul=='referer')
        {
        $eintrag_ungekuertzt=$eintrag;
        $eintrag=htmlentities(substr($eintrag,0,100)).' '.htmlentities(substr($eintrag,100,100));
        }
       elseif(!isset($eintrag_ungekuertzt)) $eintrag_ungekuertzt=$eintrag;
       if($modul=='weekday' && isset($tag_namen[$eintrag])) $eintrag=$tag_namen[$eintrag];
       elseif($modul=='referer') $eintrag='<a href=\''.linkprep($eintrag_ungekuertzt).'\' class="referer" target="_blank">'.$eintrag.'</a>';
       if($modul=='file') echo "<tr><td title='".str_replace("'",'&#39;',htmlentities($eintrag_ungekuertzt))."' style='cursor:help'>".$eintrag."</td>";
       else echo '<tr'.($separate?' class="separate"':'').'><td'.$markiere.'>'.$eintrag.'</td>';
       echo '<td'.$markiere.'>'.$anzahl.'</td><td'.$markiere.'><img src="img/bar1.gif" height="10" width="'.$prozent2.'" title="'.$prozent.'%" alt="'.$prozent.'%" /><img src="img/bar0.gif" height="10" width="'.$rest.'" title="'.$prozent.'%" alt="" /></td></tr>'."\n    ";
       unset($eintrag_ungekuertzt);
       $i++;
       }
      else break;
      }
     }
    echo '</tbody>';
    echo '</table>';
    if($_SESSION['scroll'] && in_array($modul, $list_modules_limit) && $modul!='referer' && $modul!='keyword')
     {
     echo '</div>';
     }
    echo '</td></tr>';
    }
   echo "\n".'   </table>';
   }
  }
 if(!isset($_GET['modul']))
  {
  echo "\n".'   </div>';
  if(is_file('extensions/sortabletable.js') && $modul!='hit' && ($modul!='referer' || $_SESSION['tree']===false))
   { 
   ?>
   <script type="text/javascript">
   t=new SortableTable(document.getElementById('daten_<?php echo $modul; ?>'), 100);
   </script>
   <?php
   }
  }
 echo "\n".'   <!-- Ende Modul '.ucfirst($modul).' -->'."\n";
 }

// Konsole, die die Buttons neben dem Modul-namen enthaellt
function konsole($modul)
 {
 global $list_modules_limit, $list_modules_diagram, $config_stat_limit, $config_stat_cache,$config_stat_ext_lytebox;
 $module_anz = count($_SESSION['module_'.$modul.'_data']);

 // Calendar-Button
 $konsolenzeile='<a href="calendar.php?'.SIDX.'&amp;module='.$modul."\" ".($config_stat_ext_lytebox?'rel="lyteframe" title="'.L_MODULEOUT_CONSOLE_PERIOD_DEFINE.'" rev="width: 240px; height: 500px; scrolling: no;"':"onclick=\"kalender=window.open('calendar.php?".SIDX."&amp;module=".$modul."','kalender','height=500, width=240'); kalender.focus(); return false;\"")."><img src=\"img/calendar.png\" width=\"16\" height=\"16\" alt=\"".L_MODULEOUT_CONSOLE_PERIOD."\" title=\"".L_MODULEOUT_CONSOLE_PERIOD_DEFINE."\" align=\"right\" class=\"icon\" /></a>";
 // Refresh-Button
 if($config_stat_cache)
  {
  $konsolenzeile.='<a href="show_stat.php?'.SIDX.'&amp;changed='.$modul.'" onclick="return refresh(\''.$modul.'\',\'mode=refresh\');"><img src="img/refresh.png" align="right" title="'.L_REFRESH.'" alt="'.L_REFRESH.'" width="16" height="16" class="icon" /></a>';
  }
 // IP-Button
 $konsolenzeile.='<a href="show_stat.php?'.SIDX.'&amp;ip_'.$modul.'='.($_SESSION['set_'.$modul.'_ip']?'0':'1').'" onclick="return refresh(\''.$modul.'\',\'mode=ip'.($_SESSION['set_'.$modul.'_ip']?0:1).'\');"><img src="img/ip'.($_SESSION['set_'.$modul.'_ip']?1:0).'.png" alt="'.($_SESSION['set_'.$modul.'_ip']?L_MODULEOUT_IP1:L_MODULEOUT_IP0).'" title="'.($_SESSION['set_'.$modul.'_ip']?L_MODULEOUT_IP1:L_MODULEOUT_IP0).'. '.($_SESSION['set_'.$modul.'_ip']?L_MODULEOUT_CLICK_IP0:L_MODULEOUT_CLICK_IP1).'" width="16" height="16" align="right" class="icon" /></a>';
 // Chart-Buttons
 if(in_array($modul,$list_modules_diagram)) $konsolenzeile.="<a href=\"show_stat.php?".SIDX."&amp;diagramm_".$modul."=".($_SESSION['set_'.$modul.'_piechart']?0:1)."\" onclick=\"return refresh('".$modul."','mode=diagramm".($_SESSION['set_'.$modul.'_piechart']?0:1)."');\"><img src=\"img/chart_".($_SESSION['set_'.$modul.'_piechart']?"pie":"bar").".png\" alt=\"".($_SESSION['set_'.$modul.'_piechart']?L_MODULEOUT_PIE_CHART:L_MODULEOUT_BAR_CHART)."\" title=\"".($_SESSION['set_'.$modul.'_piechart']?L_MODULEOUT_PIE_CHART:L_MODULEOUT_BAR_CHART)."\" width=\"16\" height=\"16\" align=\"right\" class=\"icon\" /></a>";
 // Limit-/All-Button
 if(in_array($modul,$list_modules_limit) && ($module_anz>$config_stat_limit[$modul] || $modul=='referer'))
  {
  if(!$_SESSION['set_'.$modul.'_all']) $konsolenzeile.="<a href='show_stat.php?".SIDX."&amp;".$modul."_all=1' onclick=\"return refresh('".$modul."','mode=all');\"><img src='img/all.png' align='right' alt='".L_MODULEOUT_CONSOLE_ALL_ABR."' title='".L_MODULEOUT_CONSOLE_ALL."' class=\"icon\" /></a>";
  else $konsolenzeile.="<a href='show_stat.php?".SIDX."&amp;".$modul."_all=0' onclick=\"return refresh('".$modul."','mode=limit');\"><img src='img/limit.png' align='right' alt='Limit' title='".L_MODULEOUT_CONSOLE_SHOW_ONLY.' '.$config_stat_limit[$modul]."' class=\"icon\" /></a>";
  }
 // Referer-Buttons
 if($modul=='referer')
  {
  if($_SESSION['tree']===false) $konsolenzeile.='<a href="show_stat.php?'.SIDX.'&amp;tree=mk&amp;" onclick="return refresh(\'referer\',\'mode=referer_tree_mk\');"><img src="extensions/tree.png" align="right" alt="'.L_MODULEOUT_CONSOLE_TREE_ABR.'" title="'.L_MODULEOUT_CONSOLE_TREE.'" class="icon" /></a>';
  else
   $konsolenzeile.=($_SESSION['tree']=='ajax'? '<a href="show_stat.php?'.SIDX.'&amp;tree=0" onclick="return refresh(\'referer\',\'mode=referer_tree0\');"><img src="extensions/list.png" align="right" alt="'.L_MODULEOUT_CONSOLE_TREE_OFF_ABR.'" title="'.L_MODULEOUT_CONSOLE_TREE_OFF.'" class="icon" /></a>'
                           : '<a href="show_stat.php?'.SIDX.'&amp;tree=ajax" onclick="return refresh(\'referer\',\'mode=referer_tree_ajax\');"><img src="extensions/tree.png" align="right" alt="'.L_MODULEOUT_CONSOLE_TREE_OTHER.'" title="'.L_MODULEOUT_CONSOLE_TREE_OTHER.'" class="icon" /></a>')
                           . '<a href="nojs.php" onclick="collapseTree('.($_SESSION['tree']=='ajax'? '':'\'tree1\'').'); return false;"><img src="extensions/minus.gif" align="right" alt="'.L_MODULEOUT_CONSOLE_TREE_COLLAPSE.'" title="'.L_MODULEOUT_CONSOLE_TREE_COLLAPSE.'" class="icon" /></a> <a href="nojs.php" onclick="expandTree('.($_SESSION['tree']=='ajax'? '1':'\'tree1\'').'); return false;"><img src="extensions/plus.gif" align="right" alt="'.L_MODULEOUT_CONSOLE_TREE_EXPAND.'" title="'.L_MODULEOUT_CONSOLE_TREE_EXPAND.'" class="icon" /></a>';
  }
 return $konsolenzeile;
 }

// Große zahlen menschenfreundlich ausgeben (für Farbtiefe) 
function prettyInt($number)
 {
 $suffix=explode(' ',L_MODULEOUT_PRETTYINT_SUFFIX);
 $i=-2;
 if($number<1000000)
  {
  $number=number_format($number,0,',','.');
  return $number;
  }
 while($number>=1000 && $i<(count($suffix)-1))
  {
  $number/=1000;
  $i++;
  }
 if($i>=(count($suffix)-1))
  {
  $number=number_format($number,0,',','.').' '.$suffix[$i];
  return $number;
  }
 return str_replace('.',',',round($number,1)).' '.$suffix[$i];
 }
 

// Prozent-Funktion
function prozent($teil, $gesamt)
 {
 if($gesamt==0) return 0;
 return @round($teil/$gesamt*100);
 }
 
function average($gesamt,$module_werte)
 {
 if(empty($module_werte)) return 0;
 $i=0;
 foreach($module_werte as $wert)
  {
  if($wert!=0) $i=0;
  else $i++;
  }
 $c=count($module_werte)-$i;
 if($c==0) return 0;
 return round($gesamt/$c,2);
 }
 
/* this is from http://php.net/json_encode by Steve (01-May-2008 12:35), originally by jjoss (same page) 
   it implements json_encode for php4 */

if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}

?>
