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

*** log-tool/index.php ***
Funktion:    Wandelt Logdateien um, komprimiert oder dekomprimiert, splittet sie oder fuehrt sie zusammen
Aufrufbar:   ja
Eingebunden: nein
*/

function convert_log_data($datenIn, $verIn=1.5, $verOut=1.6)
 {
 if($verIn==1.6 && $verOut==1.5)  // neue -> alte Log umwandeln
  {
  $datenOut[0]=(isset($datenIn[0])?$datenIn[0]:'');;
  $datenOut[1]='|';
  $datenOut[2]=(isset($datenIn[1])?$datenIn[1]:'');;
  $datenOut[3]='|';
  @$datenOut[4]=date('H',$datenIn[1]);
  @$datenOut[5]=date('i',$datenIn[1]);
  @$datenOut[6]=date('s',$datenIn[1]);
  $datenOut[7]='|';
  @$datenOut[8]=date('w',$datenIn[1]);
  $datenOut[9]='|';
  @$datenOut[10]=date('d',$datenIn[1]);
  @$datenOut[11]=date('m',$datenIn[1]);
  @$datenOut[12]=date('Y',$datenIn[1]);
  $datenOut[13]='|';
  $datenOut[14]=(isset($datenIn[2])?$datenIn[2]:'');;
  $datenOut[15]='|';
  $datenOut[16]=(isset($datenIn[3])?$datenIn[3]:'');;
  $datenOut[17]='|';
  $datenOut[18]=(isset($datenIn[4])?$datenIn[4]:'');;
  $datenOut[19]='|';
  $datenOut[20]=(isset($datenIn[5])?$datenIn[5]:'');;
  $datenOut[21]='|';
  $datenOut[22]=(isset($datenIn[6])?$datenIn[6]:'');
  $datenOut[23]='|';
  $datenOut[24]=(isset($datenIn[7])?$datenIn[7]:'');
  }
 elseif($verIn==1.5 && $verOut==1.6) // ohne Parameter: alte -> neu Log umwandeln
  {
  $datenOut[0]=(isset($datenIn[0])?trim($datenIn[0]):'');
  $datenOut[1]=(isset($datenIn[2])?trim($datenIn[2]):'');
  $datenOut[2]=(isset($datenIn[14])?trim($datenIn[14]):'');
  $datenOut[3]=(isset($datenIn[16])?trim($datenIn[16]):'');
  $datenOut[4]=(isset($datenIn[18])?trim($datenIn[18]):'');
  $datenOut[5]=(isset($datenIn[20])?trim($datenIn[20]):'');
  $datenOut[6]=(isset($datenIn[22])?trim($datenIn[22]):'');
  $datenOut[7]=(isset($datenIn[24])?trim($datenIn[24]):'');
  $datenOut['m']=(isset($datenIn[11])?trim($datenIn[11]):'');
  $datenOut['Y']=(isset($datenIn[12])?trim($datenIn[12]):'');
  $datenOut['d']=(isset($datenIn[10])?trim($datenIn[10]):'');
  $datenOut['w']=(isset($datenIn[8])?trim($datenIn[8]):'');
  $datenOut['H']=(isset($datenIn[4])?trim($datenIn[4]):'');
  }
 return $datenOut;
 }
 
function is_file_or_gz($filename)
 {
 if(is_file($filename)) return $filename;
 elseif(is_file($filename.'.gz')) return $filename.'.gz';
 else return false; 
 }
 
session_start();

if(is_file('../../usr/config.php') && is_file('../password_protect.php'))
 {
 @include_once('../config_default.php');
 require_once('../../usr/config.php');
 if(!$config_stat_password_protect) $meldung='Geben Sie die Zugangsdaten, die in "config_pass.php" eingestellt sind ein, um das Log-Tool zu starten.';
 $config_stat_password_protect=true;
 require_once('../password_protect.php');
 $protected=true;
 }
elseif(is_file('password_protect.php'))
 {
 // Wenn Sie das Logtool allein betreiben, stellen Sie hier das Passwort ein
 $config_stat_passwort="GeheimesPasswort";
 $config_stat_username="admin";
 
 $meldung='Geben Sie die Zugangsdaten, die in der Log-Tool-Datei eingestellt sind ein, um das Log-Tool zu starten.';
 require_once('password_protect.php');
 $protected=true;
 }
else
 {
 die('<html><body>Kopieren Sie die Datei "password_protect.php" (aus CrazyStat) in das Verzeichnis des Log-Tools, &ouml;ffnen Sie die php-Datei des Log-Tools und passen die Zugangsdaten an. Ohne Passwortschutz arbeitet das Tool nicht!</body></html>');
 }

if(isset($_GET['reset'])) unset($_SESSION['clog_ausgangsformat'],$_SESSION['clog_ausgangsdatei_splits'],$_SESSION['clog_zielformat'],$_SESSION['clog_erneuereZeilen'],$_SESSION['clog_splitting'],$_SESSION['clog_split'],$_SESSION['clog_splitting'],$_SESSION['clog_kompression'],$_SESSION['clog_source_path'],$_SESSION['clog_source_name'],$_SESSION['clog_target_path'],$_SESSION['clog_target_name'],$_SESSION['clog_zlib']);
if(isset($_POST['ausgangsformat'])) $_SESSION['clog_ausgangsformat']=$_POST['ausgangsformat'];
if(isset($_POST['source_path'])) $_SESSION['clog_source_path']=$_POST['source_path'];
if(isset($_POST['source_name'])) $_SESSION['clog_source_name']=$_POST['source_name'];
if(isset($_POST['target_path'])) $_SESSION['clog_target_path']=$_POST['target_path'];
if(isset($_POST['target_name'])) $_SESSION['clog_target_name']=$_POST['target_name'];
if(isset($_POST['ausgangsdatei_splits'])) $_SESSION['clog_ausgangsdatei_splits']=$_POST['ausgangsdatei_splits'];
if(isset($_POST['zielformat']))
 {
 $_SESSION['clog_zielformat']=$_POST['zielformat'];
 if(isset($_POST['erneuereZeilen']) && $_POST['erneuereZeilen']=='on')
  {
  $_SESSION['clog_erneuereZeilen']=true;
  }
 else $_SESSION['clog_erneuereZeilen']=false;
 if(isset($_POST['anonymeIPs']) && $_POST['anonymeIPs']=='on')
  {
  $_SESSION['clog_anonymeIPs']=true;
  }
 else $_SESSION['clog_anonymeIPs']=false;
 }
if(isset($_POST['splitting']))
 {
 if(isset($_POST['split']) && $_POST['split']=='on')
  {
  $_POST['splitting']=str_replace(',','.',$_POST['splitting']);
  if(!is_numeric($_POST['splitting'])) die('Bitte Zahl eingeben.');
  $_SESSION['clog_splitting']=$_POST['splitting'];
  $_SESSION['clog_split']=true;
  }
 else $_SESSION['clog_split']=false;
 }
if(isset($_POST['sent']))
 {
 if(isset($_POST['kompression']) && $_POST['kompression']=='on')
  {
  $_SESSION['clog_kompression']=true;
  $_SESSION['clog_zlib']=false;
  }
 else $_SESSION['clog_kompression']=false;
 if(isset($_POST['zlib']) && $_POST['zlib']=='on' && function_exists('stream_get_wrappers') && in_array('compress.zlib', stream_get_wrappers()))
  {
  $_SESSION['clog_zlib']=true;
  $_SESSION['clog_kompression']=false;
  }
 else $_SESSION['clog_zlib']=false;
 }

header('Content-Type: text/html; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>CrazyStat Log-Tool</title>
  <link href="../style.css" rel="stylesheet" type="text/css" />
  <meta name="generator" content="CrazyStat" />
 </head>
 <body id="body">
  <h1><img src="../img/crazystat.gif" alt="CrazyStat" title="" width="146" height="35" /></h1>
  <h2>Log-Tool</h2>
  <form action="index.php" method="post" enctype="multipart/form-data">
<?php
if(!isset($_REQUEST['schritt']) || !is_numeric($_REQUEST['schritt']) || $_REQUEST['schritt']>6 || $_REQUEST['schritt']<=0)
 {
?>
  <h3>Willkommen...</h3>
  <p>
  ... im CrazyStat Log-Tool. Mit diesem Tool k&ouml;nnen Sie leicht und bequem CrazyStat-Logdateien konvertieren, komprimieren, dekomprimieren,
  splitten und zusammenf&uuml;hren.<br />
  In f&uuml;nf einfachen Schritten w&auml;hlen Sie aus, wie Ihre Logdatei jetzt ist, und wie sie werden soll.<br />
  Alle Einstellungen sind gut erkl&auml;rt.<br />
  Das Tool wird versuchen alle Einstellungen automatisch zu ermitteln, sodass die Vorgabewerte i.d.R. belassen werden k&ouml;nnen.
  <br />
  Dieses Tool beginnt mit den gew&uuml;nschten Aktionen erst, nachdem Sie auf "Fertig stellen" klicken.
  </p>
  <p><i><strong>English Users</strong>: At the moment, the logtool is only available in German. As it is not neccessary for fresh installations,
  translation of the logtool was not done yet (it is essential to upgrade, but CrazyStat was not available
  in English yet so there should be no English users updating. Please visit <a href="http://en.christosoft.de" target="_blank">en.christosoft.de</a>
  to check if it has been translated in the meantime).</i></p>
  <input type="hidden" name="schritt" value="1" />
  <?php if(isset($_SESSION['clog_ausgangsformat'])) { ?><input type="button" value="Alles zur&uuml;cksetzen" onclick="if(confirm('Möchten Sie wirklich alle Einstellungen auf Standard zurücksetzen?'))location.href='index.php?reset=1';" /><?php } ?>
  <input type="submit" value="Start" />
<?php
 }
else
 {
 $schritt=$_REQUEST['schritt'];
 echo '<input type="hidden" name="schritt" value="'.($schritt+1).'" />';
 switch($schritt)
  {
  case 1:
?>
   <h3>Schritt 1/5: Quelle</h3>
   <p>
   <b>Welches Format hat die Logdatei, die dieses Tool nun verarbeiten soll?</b><br />
   Wenn Sie vorher CrazyStat 1.5x verwendet haben, w&auml;hlen Sie hier "1.5".
   Wenn Ihre Logdatei von CrazyStat 1.6x, 1.7x oder diesem Tool bereits im neuen Platz sparendem 1.6-Format erstellt wurde, w&auml;hlen Sie "1.6".
   </p>
   <p>
    Ausgangsformat: <select name="ausgangsformat" size="1">
    <option<?php if((isset($_SESSION['clog_ausgangsformat']) && $_SESSION['clog_ausgangsformat']=='1.6') || (!isset($_SESSION['clog_ausgangsformat']) && $config_log_ver==1.6)) echo ' selected="selected"'; ?>>1.6</option>
    <option<?php if((isset($_SESSION['clog_ausgangsformat']) && $_SESSION['clog_ausgangsformat']=='1.5') || (!isset($_SESSION['clog_ausgangsformat']) && $config_log_ver==1.5)) echo ' selected="selected"'; ?>>1.5</option>
    </select>
   </p>
   <p>
   <b>Geben Sie den Pfad zu den Dateien ein, die verarbeitet werden sollen.</b><br />
   Hier geben Sie an, wo die Logdateien liegen, die verarbeitet werden sollen (Beispiel: .. oder ../logs).
   Der Pfad sollte relativ vom Logtool aus sein; ".." bedeutet einen Ordner zur&uuml;ck. Geben Sie weder einen
   abschlie&szlig;enden Slash (/) noch einen Slash am Anfang an. Verwenden Sie keine Backslashs (\) sondern normale (/).
   </p><p>
   <?php
   if(is_file('../stat.log') || is_file_or_gz('../stat0.log')!==false) $guessed_path='..';
   elseif(is_file_or_gz('../logs/stat0.log')!==false) $guessed_path='../logs';
   elseif(is_file_or_gz('in/stat.log')!==false) $guessed_path='in';
   elseif(isset($config_logfile_folder) && is_file_or_gz('../../usr/'.$config_logfile_folder.'/stat0.log')!==false) $guessed_path='../../usr/'.$config_logfile_folder;
   else $guessed_path='';
   echo 'Quell-Pfad: <input type="text" name="source_path" value="'.(isset($_SESSION['clog_source_path'])?$_SESSION['clog_source_path']:$guessed_path).'" />';
   if($guessed_path!='') echo '<br />Es wurden Logdateien im Pfad "'.$guessed_path.'" gefunden.';
   ?>
   </p>
   <b>Geben Sie den Dateinamen der Ausgangs-Logdateien an</b>
   <p>Wenn Ihre Logdatei stat.log oder stat0.log hei&szlig;t oder Ihre Logdateien gesplittet sind (stat0.log, stat1.log, ...), so geben Sie hier "stat.log" ein (<u>die Nummerierung wird automatisch eingef&uuml;gt</u>).<br />
   Wenn die Logdateien gz-komprimiert vorliegen, also z.B. stat0.log.gz, ... heißen, geben Sie auch nur stat0.log ein. Die gz-Kompression wird automatisch erkannt.<br />
   <b>Dies ist immer "stat.log", außer wenn Sie $config_logfile_name ver&auml;ndert haben oder die Logdateien manuell umbenannt haben.</b>
   </p><p>
   <?php
   echo 'Logdatei-Name: <input type="text" name="source_name" value="'.(isset($_SESSION['clog_source_name'])?$_SESSION['clog_source_name']:(isset($config_logfile_name)?$config_logfile_name:'stat.log')).'" />';
   ?> 
   </p>  

<?php
  break;
  case 2:
?>
   <h3>Schritt 2/5: Ziel</h3>
   <p>
   <b>Welches Format m&ouml;chten Sie zuk&uuml;nftig f&uuml;r Ihre CrazyStat-Logdateien verwenden?</b><br />
   CrazyStat 1.7x unterstützt nur noch das Logformat 1.6. Wenn Sie die Logdateien mit CrazyStat 1.6x verwenden möchten, können Sie zwischen 1.6 (kleiner) und 1.5 (ein wenig schneller) wählen. CrazyStat 1.5x unterstützt nur das Format 1.5.<br />
   <b>Wählen Sie 1.6 für CrazyStat 1.7x.</b>
   </p>
   <p>
    Zielformat: <select name="zielformat" size="1">
    <option<?php if(isset($_SESSION['clog_zielformat']) && $_SESSION['clog_zielformat']=='1.6') echo ' selected="selected"'; ?>>1.6</option>
    <option<?php if(isset($_SESSION['clog_zielformat']) && $_SESSION['clog_zielformat']=='1.5') echo ' selected="selected"'; ?>>1.5</option>
    </select>
   </p>
   
   <p>
   <b>Soll die Zeilenz&auml;hlung erneuert werden?</b><br />
   Die Eintr&auml;ge in den CrazyStat-Logs werden durchgez&auml;hlt. Es kann unter bestimmten Umst&auml;nden dazu kommen,
   dass die Z&auml;hlungen nicht stimmen. Sie k&ouml;nnen die Z&auml;hlung erneuern lassen, sodass sie wieder korrekt ist.
   </p>
   <p>
    <input type="checkbox" name="erneuereZeilen" <?php if(!isset($_SESSION['clog_erneuereZeilen']) || $_SESSION['clog_erneuereZeilen']) echo 'checked="checked"'; ?> /> Zeilenz&auml;hlung erneuern (empfohlen)
   </p>
   
   <p>
   <b>Sollen IPs anonymisiert werden?</b><br />
   CrazyStat kann IPs anonymisiert abspeichern, sodass die tatsächliche IP sich aus den Logdateien nicht mehr ableiten lässt.
   Unter Umständen ist es in Ihrem Land nicht erlaubt, IPs zu speichern.
   Erkundigen Sie sich über die aktuelle Rechtlage in Ihrem Land. <b>Sollten Sie sich nicht sicher sein, schalten Sie die
   Anonymisierung ein.</b> Sie weist jeder IP eine eindeutige Zeichenfolge (ihren salted MD5-Hash) zu. Da dieser Wert eindeutig ist,
   funktioniert die IP-Sperre weiterhin.<br />
   Eine einmal anonymisierte IP kann aber nicht wieder rückgerechnet werden, deshalb kann dieser Vorgang nicht rückgängig gemacht werden!
   </p>
   <p>
    <input type="checkbox" name="anonymeIPs" <?php if(isset($_SESSION['clog_anonymeIPs']) && $_SESSION['clog_anonymeIPs']) echo 'checked="checked"'; ?> /> IPs anonymisieren
   </p>
   
   <p>
    <b>Wo soll(en) die Zieldatei(en) abgelegt werden?</b><br />
    Geben Sie an, wo die Zieldateien relativ vom Logtool gesehen abgelegt werden sollen. Normalerweise liegen die Dateien im Unterordner "logs" des CrazyStat-Verzeichnisses.
    In diesem Fall m&uuml;ssen Sie "../logs" angeben.
    Geben Sie den Pfad ohne Slashs am Anfang oder Ende an, ".." steht f&uuml;r einen Ordner zur&uuml;ck. Verwenden Sie keine Backslashs (\) sondern normale (/).<br />
    <b style="color:red">Der Zielordner wird <u>geleert</u> bevor die neuen Logs dorthin geschoben werden</b> (die .htaccess bleibt erhalten). Sie k&ouml;nnen als Zielordner ohne Probleme den Quellordner angeben. <br />
    Ziel-Pfad: <input type="text" name="target_path" value="<?php echo (isset($_SESSION['clog_target_path'])?$_SESSION['clog_target_path']:(isset($_SESSION['clog_source_path'])?$_SESSION['clog_source_path']:'../logs')); ?>" /><br />
   </p>
   <p>
    <b>Wie soll die Zieldatei hei&szlig;en?</b><br />
    Bitte geben Sie an, wie die neue Logdatei hei&szlig;en soll. Der Dateiname muss einen Punkt enthalten. Vor dem Punkt wird die Split-Nummer
    automatisch eingef&uuml;gt (bzw. "0" wenn Sie kein Splitting verwenden).<br />
    <input type="text" name="target_name" value="stat.log" />
   </p>
   
<?php
  break;
  case 3:
  
  $anz_logs=0;
  while(is_file_or_gz($_SESSION['clog_source_path'].'/'.substr($_SESSION['clog_source_name'],0,strpos($_SESSION['clog_source_name'],'.')).$anz_logs.substr($_SESSION['clog_source_name'],strpos($_SESSION['clog_source_name'],'.')))!==false) $anz_logs++;
?>
   <h3>Schritt 3/5: Splitting</h3>
   <p>
   <b>Ist die Ausgangsdatei gesplittet?</b><br />
   Wenn Ihre Logdatei von CrazyStat > 1.60 oder diesem Tool bereits gesplittet wurde, geben Sie ein, in wie viele Dateien. Wenn Ihre Datei
   nicht gesplittet ist, lassen Sie "1" stehen. Wenn Ihre letzte Logdatei "stat12.log" hei&szlig;t, geben Sie "13" ein (da die Z&auml;hlung bei 0 startet).
   </p>
   <p>
   Ausgangsdatei gesplittet in <input type="text" name="ausgangsdatei_splits" value="<?php echo (isset($_SESSION['clog_ausgangsdatei_splits'])?$_SESSION['clog_ausgangsdatei_splits']:$anz_logs); ?>" size="2" /> Dateien.
   </p>
   <p>
   <b>Wie gro&szlig; sollen Ihre Logdateien maximal werden?</b><br />
   CrazyStat 1.6x kann Logdateien splitten. Das bedeutet, dass ab einer gewissen Logdateigr&ouml;&szlig;e eine neue Logdatei angelegt wird. Dies ist zum
   einem dann wichtig, wenn auf Ihrem Servern eine maximale Dateigr&ouml;&szlig;e eingestellt ist. Au&szlig;erdem m&uuml;ssen Sie nicht mehr alle
   Logdateien backuppen sondern nur noch die letzten. Au&szlig;erdem wird mit dem Splitting demn&auml;chst das Auswerten der Logdateien beschleunigt.
   CrazyStat 1.5x kann nicht mit gesplitteten Logfiles umgehen.<br />
   <b>Es wird empfohlen, Ihre Logdatei zu splitten. Ein sinnvoller Wert ist 1MB.</b>
   </p>
   <p>
    <input type="checkbox" name="split" <?php if(!isset($_SESSION['clog_split']) || $_SESSION['clog_split']) echo 'checked="checked"'; ?> /> Splitten nach: <input type="text" name="splitting" value="<?php echo (isset($_SESSION['clog_splitting'])?$_SESSION['clog_splitting']:1); ?>" size="2" /> MB
   </p>
<?php
  break;
  case 4:
?>
   <h3>Schritt 4/5: Kompression</h3>
<?php
  if($_SESSION['clog_zielformat']==1.6)
   {
?>
   <p>
   <b>M&ouml;chten Sie Kompression verwenden, um erheblich kleinere Logdateien zu erhalten?</b><br />
   CrazyStat 1.7x unterstützt echte gz-Kompression, was zu erheblich kleineren Logdateien führt.<br />
   CrazyStat 1.6x unterstützt ein eigenes "Kompressionsverfahren", welches die Logdateien ein gutes Stück kleiner macht.<br />
   CrazyStat 1.5x unterstützt keine Kompression.
   </p>
   <p>
    <input type="checkbox" name="kompression" <?php if(isset($_SESSION['clog_kompression']) && $_SESSION['clog_kompression']) echo 'checked="checked"'; ?> /> "Kompression" verwenden (nur möglich bei <b>CrazyStat 1.6x</b>)<br />
    <input type="checkbox" name="zlib" <?php if(!isset($_SESSION['clog_zlib']) || $_SESSION['clog_zlib']) echo 'checked="checked"'; ?> /> gz-Kompression verwenden (nur möglich bei <b>CrazyStat 1.7x</b>)
    <input type="hidden" name="sent" value="1" />
   </p>
<?php
   }
  else
   {
   $_SESSION['clog_zlib']=false;
   $_SESSION['clog_kompression']=false;
?>
   <p>Das gew&uuml;nschte Zielformat unterst&uuml;tzt keine Kompression.</p>
<?php
   }
  break;
  case 5:
?>
   <h3>Schritt 5/5: Zusammenfassung</h3>
   <p>
   <b>Sie haben folgende Einstellungen gew&auml;hlt:</b></p>
   <table border="1">
   <tr><th>&nbsp;</th><th>Quelle</th><th>Ziel</th></tr>
   <tr><td>Logformat:</td><td><?php echo $_SESSION['clog_ausgangsformat']; ?></td><td><?php echo $_SESSION['clog_zielformat']; ?></td></tr>
   <tr><td>Pfad: </td><td><?php echo $_SESSION['clog_source_path']; ?></td><td><?php echo $_SESSION['clog_target_path']; ?></td></tr>
   <tr><td>Dateiname: </td><td><?php echo $_SESSION['clog_source_name']; ?></td><td><?php echo $_SESSION['clog_target_name']; ?></td></tr>
   <tr><td>Splitting: </td><td><?php echo $_SESSION['clog_ausgangsdatei_splits']; ?> Dateien</td><td><?php echo ($_SESSION['clog_split']?'Ja nach '.$_SESSION['clog_splitting'].'MB':'Nein'); ?></td></tr>
   <tr><td>Kompression: </td><td>(auto)</td><td><?php echo ($_SESSION['clog_kompression']?'Ja':'Nein'); ?></td></tr>
   <tr><td>gz-Kompression: </td><td>(auto)</td><td><?php echo ($_SESSION['clog_zlib']?'Ja':'Nein'); ?></td></tr>
   <tr><td>Zeilen erneuern: </td><td>&nbsp;</td><td><?php echo ($_SESSION['clog_erneuereZeilen']?'Ja':'Nein'); ?></td></tr>
   <tr><td>IPs anonymisieren: </td><td>&nbsp;</td><td><?php echo ($_SESSION['clog_anonymeIPs']?'Ja':'Nein'); ?></td></tr>
   
   </table>

   <p>
   <?php
   $fertig=true;
   echo '<input type="button" value="Zur&uuml;ck" onclick="location.href=\'index.php?schritt='.($schritt-1).'\';" />  <input type="submit" value="Fertig stellen"  onclick="this.disabled=true; this.value=\'Bitte warten...\'; document.getElementById(\'body\').style.cursor=\'wait\'; this.form.submit();" />';
   ?>
   </p>
<?php
  break;
  case 6:
  @set_time_limit(900);
  ignore_user_abort(false);
  echo '<h3>Gew&uuml;nschte Aktionen werden ausgef&uuml;hrt</h3><p style="font-size:8pt;">';
  if(is_file('../log_funcs.php')) require_once('../log_funcs.php');
  elseif(is_file('log_funcs.php')) require_once('log_funcs.php');
  else die('Fehler: Die Datei log_funcs.php wurde nicht gefunden.');
  
  @mkdir('out',0777);
  // out leeren
  $dirhandle=opendir('out');
  while(false !== ($eintrag=readdir($dirhandle)))
   {
   if(is_file('out/'.$eintrag) && $eintrag[0]!='.')
    {
    unlink('out/'.$eintrag);
    }
   }
   
  $neuesVerzeichnis='out';
  $altesVerzeichnis=$_SESSION['clog_source_path'];
  if(!is_dir($altesVerzeichnis))
   {
   echo 'Fehler: Ausgangs-Verzeichnis nicht vorhanden.';
   break;
   }
  
  $neueDatei['name']=$neuesVerzeichnis.'/'.substr($_SESSION['clog_target_name'],0,strpos($_SESSION['clog_target_name'],'.'));
  $neueDatei['ext']=substr($_SESSION['clog_target_name'],strpos($_SESSION['clog_target_name'],'.'));
  $neueDatei['i']=0;
  
  echo '<br />Schreibe in Datei '.$neueDatei['name'].$neueDatei['i'].$neueDatei['ext'];
  
  
  $size_uncompressed=0;
  $size_uncompressed_total=0; 
  $salt_str=mt_rand();
  $zeilennr=0;
  @$max=$_SESSION['clog_splitting']*1000*1000;
  $erneuert=0;
  $size_original_total=0;
  for($i=0;$i<$_SESSION['clog_ausgangsdatei_splits'];$i++)
   {
   $tmp_name=$altesVerzeichnis.'/'.substr($_SESSION['clog_source_name'],0,strpos($_SESSION['clog_source_name'],'.')).$i.$neueDatei['ext'];
   if(is_file($tmp_name.'.gz'))
    {
    $fh_tmp=fopen('compress.zlib://'.$tmp_name.'.gz','r');
    while(!feof($fh_tmp))
     {
     $log_line=fgets($fh_tmp);
     $size_original_total+=strlen($log_line);     
     }
    fclose($fh_tmp);
    }
   else $size_original_total+=filesize($tmp_name);
   }

  if($_SESSION['clog_zlib'] && ($size_uncompressed_total+$max)<$size_original_total)
   {
   echo '.gz'; 
   $handle2=fopen('compress.zlib://'.$neueDatei['name'].$neueDatei['i'].$neueDatei['ext'].'.gz','a');
   }
  else
   { 
   $handle2=fopen($neueDatei['name'].$neueDatei['i'].$neueDatei['ext'],'a');
   }


  for($i=0;$i<$_SESSION['clog_ausgangsdatei_splits'];$i++)
   {
   flush();
   $tmp_name=$altesVerzeichnis.'/'.substr($_SESSION['clog_source_name'],0,strpos($_SESSION['clog_source_name'],'.')).$i.$neueDatei['ext'];
   $name=basename($tmp_name);
 
   echo '<br />Lese aus Datei '.$name;
   if(!file_exists($tmp_name) && !file_exists($tmp_name.'.gz')) die('<br /><b>Fehler: Datei nicht gefunden!</b>');
   $handle=open_logfile($tmp_name,'r');
   while(!feof($handle))
    {
    $zeile=fgets($handle);
    $size_uncompressed+=strlen($zeile);
    if(empty($zeile))
     {
     echo '<br />&Uuml;berspringe leere Zeile.';
     continue;
     }
    $daten=explode('#',$zeile);
 
    if($_SESSION['clog_ausgangsformat']==1.6 ) // entkomprimieren
     {
     foreach($daten as $id=>$data)
      {
      $data=trim($data);
      if($data!='^') $letzte_daten1[$id]=$data;
      else $daten[$id]=$letzte_daten1[$id];
      }
     }
 
    if($_SESSION['clog_ausgangsformat']!=$_SESSION['clog_zielformat']) // konvertieren
     {
     if($_SESSION['clog_ausgangsformat']==1.5) $daten=convert_log_data($daten, 1.5, 1.6);
     else $daten=convert_log_data($daten, 1.6, 1.5);
     }
    if($_SESSION['clog_split']) // splitten
     {
     clearstatcache();
     if($size_uncompressed>=$max)
      {
      $size_uncompressed_total+=$size_uncompressed;
      $size_uncompressed=0;
      fclose($handle2);
      echo '<br />Schlie&szlig;e  Datei '.$neueDatei['name'].$neueDatei['i'].$neueDatei['ext'].($_SESSION['clog_zlib']?'.gz':'');
      $neueDatei['i']++;
      echo '<br />Schreibe in Datei '.$neueDatei['name'].$neueDatei['i'].$neueDatei['ext'].($_SESSION['clog_zlib']?'.gz':'');
      flush();
      if(isset($letzte_daten2)) unset($letzte_daten2);
      if($_SESSION['clog_zlib'] && ($size_uncompressed_total+$max)<$size_original_total) $handle2=fopen('compress.zlib://'.$neueDatei['name'].$neueDatei['i'].$neueDatei['ext'].'.gz','a');
      else $handle2=fopen($neueDatei['name'].$neueDatei['i'].$neueDatei['ext'],'a');
      }
     }
    $zeile='';
    if($_SESSION['clog_erneuereZeilen'] && $daten[0]!=$zeilennr)
     {
     $daten[0]=$zeilennr;
     $erneuert++;
     }
    if($_SESSION['clog_anonymeIPs'] && strlen($daten[2])<16)
     {
     $daten[2]=md5($daten[2].$salt_str);
     }
    foreach($daten as $id=>$data)
     {
     $data=trim($data);
     if(!is_numeric($id)) break;
     if($id!=0) $zeile.='#';
     if($_SESSION['clog_kompression'] && $id!=0 && !empty($letzte_daten2[$id]) && $data==$letzte_daten2[$id] && ($zeilennr%10)!=0) $zeile.='^';  // komprimieren
     else $zeile.=$data;
     $letzte_daten2[$id]=$data;
     }
    $zeile.="\n";
    fwrite($handle2,$zeile);
    $zeilennr++;
    }
   echo '<br />Bis Zeile '.$zeilennr.' (der neuen Log) aus '.$name.' gelesen. Schlie&szlig;e Datei.';
   fclose($handle);
   }
  fclose($handle2);

  if(!is_dir($_SESSION['clog_target_path']))
   {
   mkdir($_SESSION['clog_target_path'],0777);
   echo '<br />Der Zielordner war noch nicht vorhanden und wurde deshalb neu erstellt.';
   }
  // Zielordner leeren
  echo '<br />Der Zielordner wird nun geleert.';
 
  $dirhandle=opendir($_SESSION['clog_target_path']);
 
  while(false!==($eintrag=readdir($dirhandle)))
   {
   if(is_file($_SESSION['clog_target_path'].'/'.$eintrag) && $eintrag[0]!='.')
    {
    echo '<br /><b>L&ouml;sche '.$eintrag.'</b>';
    unlink($_SESSION['clog_target_path'].'/'.$eintrag);
    }
   }
  echo '<br />Leeren des Ordners abgeschlossen.';

  // Verschieben
  echo '<br />Dateien werden jetzt vom tempor&auml;ren Ordner zum Zielverzeichnis verschoben.';
  
  for($i=0;$i<=$neueDatei['i'];$i++)
   {
   if(is_file($neueDatei['name'].$i.$neueDatei['ext'].'.gz'))
    {
    $alterPfad=$neueDatei['name'].$i.$neueDatei['ext'].'.gz';
    $gz=true;
    }
   else
    {
    $alterPfad=$neueDatei['name'].$i.$neueDatei['ext'];
    $gz=false;
    }
   echo '<br />Verschiebe '.$alterPfad;
   $neuerPfad=$_SESSION['clog_target_path'].substr($neueDatei['name'],3).$i.$neueDatei['ext'].($gz?'.gz':'');
   rename($alterPfad,$neuerPfad);
   }

  rmdir('out');
  
  
  echo '<br /> Es wurden '.$erneuert.' Zeilenz&auml;hlungen erneuert.';
  if(is_file('../config_default.php') && is_file('../../usr/config.php'))
   {
   include_once('../config_default.php');
   include_once('../../usr/config.php');
   $korrekt=' // Momentan korrekt gesetzt';
   $anders=' <span style="color:red">// Momentan anderer Wert</span>';
   $hinweis1=($config_logfile_name==$_SESSION['clog_target_name']?$korrekt:$anders);
   if(($_SESSION['clog_split'] && $config_logfile_maxsize==($_SESSION['clog_splitting']*1000)) || (!$_SESSION['clog_split'] && $config_logfile_maxsize===false)) $hinweis2=$korrekt;
   else $hinweis2=$anders;
   $hinweis3=($config_log_zlib==$_SESSION['clog_zlib']?$korrekt:$anders);
   }
  else
   {
   $hinweis1=''; $hinweis2=''; $hinweis3=''; $hinweis4=''; $hinweis5='';
   }
  
  echo '</p><hr />Sollten keine Fehler gemeldet worden sein, wurden die Aktionen erfolgreich durchgef&uuml;hrt.<br />'
       .'Wenn Sie diese Logdatei(en) mit CrazyStat >= 1.70 verwenden m&ouml;chten, werden folgende Einstellungen (dringend) empfohlen:'
       .'<p style="font-family:Courier">$config_logfile_name="'.$_SESSION['clog_target_name'].'";'.$hinweis1.'<br />'
       .'$config_logfile_maxsize='.($_SESSION['clog_split']?$_SESSION['clog_splitting']*1000:'false').';'.$hinweis2.'<br />'
       .'$config_log_zlib='.($_SESSION['clog_zlib']?'true':'false').';'.$hinweis3.'<br />';
  echo '<p>Wenn Sie CrazyStat >= 1.61 verwenden, rufen Sie nach dem Anpassen der Einstellungen die Datei show_stat.php auf. Klicken Sie nach der Anmeldung auf "Cache l&ouml;schen" (falls Sie den "Default-File-Cache" verwenden). Es wird ein Counterfile erzeugt und der Counter auf den korrekten Wert gestellt.</p>';
  if($_SESSION['clog_zlib']) echo '<p>Ihre Logdateien sind <u>nur kompatibel mit CrazyStat >= 1.70</u>, da Sie gz-Kompression gewählt haben.</p>';
  if($_SESSION['clog_kompression']) echo '<p>Ihre Logdateien sind <u>nur kompatibel mit CrazyStat 1.6x, also nicht mit CrazyStat 1.70 oder höher</u>, da Sie einfache "Kompression" gewählt haben.</p>';
  if(is_file('../show_stat.php')) echo '<p><a href="../show_stat.php?clearcache=true&reload=true">Jetzt zu show_stat.php wechseln und Cache löschen</a></p>';
  if($_SESSION['clog_zielformat']==1.5 && !$_SESSION['clog_split']) echo '<p>Sie k&ouml;nnen diese Logdatei mit CrazyStat 1.5x verwenden, wenn Sie sie in "'.$_SESSION['clog_target_name'].'" umbenennen, $config_logfile_name="'.$_SESSION['clog_target_name'].'" setzen und die Datei ins Verzeichnis von CrazyStat 1.5x verschieben.</p>';
  echo 'Viel Spa&szlig; mit CrazyStat,<br />Christopher Kramer';
  echo '<br /><input type="submit" value="Zum Anfang" />';
  $fertig=true;
  break;
  }
 if(!isset($fertig) || !$fertig) echo '<input type="button" value="Zur&uuml;ck" onclick="location.href=\'index.php?schritt='.($schritt-1).'\';" /><input type="submit" value="Weiter" />';
 }
?>
  </form>
  <p><br /><br />
   <a href="http://validator.w3.org/check?uri=referer" style="font-size: 8pt; color:gray; text-decoration:none">Valid XHTML</a>
  </p>
 </body>
</html>