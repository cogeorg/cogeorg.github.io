<?php
// password_protect.php
define('L_PASSWORD_MES_ERR_NEW_INVALID','Neues Passwort leer oder Wiederholung des Passworts nicht identisch mit dem Passwort.');
define('L_PASSWORD_MES_ERR_NOT_CHANGED','Passwort wurde nicht geändert!');
define('L_PASSWORD_MES_ERR_RETRY','Erneut versuchen');
define('L_PASSWORD_MES_ERR_WRITING_FAILED','Passwort-Datei konnte nicht zum Schreiben geöffnet werden. Überprüfen Sie den CHMOD bzw. ob die Datei schreibgeschützt ist.');
define('L_PASSWORD_MES_OK_CHANGED','Passwort wurde erfolgreich geändert!');
define('L_PASSWORD_MES_ERR_NOT_LOGGED_IN','Login abgelaufen bzw. nicht eingeloggt.');
define('L_PASSWORD_MES_ERR_RELOGIN','Neu einloggen');

define('L_PASSWORD_PLEASE_LOGIN','Bitte anmelden');
define('L_PASSWORD_USERNAME','Username');
define('L_PASSWORD_PASSWORD','Passwort');
define('L_PASSWORD_DO_NOT_COUNT','Seitenaufrufe dieses Computers nicht zählen');
define('L_PASSWORD_PLEASE_WAIT','Bitte warten...');
define('L_PASSWORD_MES_ERR_WRONG_DATA','Falsche Nutzerdaten. Zugriff verweigert.');
define('L_PASSWORD_MES_OK_THANK_YOU','Vielen Dank, dass Sie CrazyStat nutzen!');
define('L_PASSWORD_MES_SUPPORT_CRAZYSTAT','<a href="http://www.christosoft.de/Unterstuetzen">Bitte unterstützen Sie CrazyStat!</a>');
define('L_PASSWORD_NO_JAVASCRIPT','Achtung! Da Ihr Browser kein JavaScript unterstützt, wird Ihr Passwort im Klartext übertragen!');
define('L_PASSWORD_CHANGE_PASSWORD','Passwort ändern');
define('L_PASSWORD_OLD_PASSWORD','Altes Passwort');
define('L_PASSWORD_NEW_PASSWORD','Neues Passwort');
define('L_PASSWORD_REPEAT_PASSWORD','Passwort wiederholen');
define('L_PASSWORD_CHANGE_AND_LOGIN','Ändern und Einloggen');
define('L_PASSWORD_MSG_ERR_NOMD5','Achtung! Das neue Passwort muss im Klartext übertragen werden, da Sie $config_stat_password_md5=false gesetzt haben.<br />Es wird empfohlen, dies auf true zu setzen und das Passwort verschlüsselt abzuspeichern (s. FAQ).');
define('L_PASSWORD_MSG_ERR_NO_MD5JS','Achtung! Das Passwort muss im Klartext übertragen werden, da die Datei src/extensions/md5.js fehlt. Es wird empfohlen, diese Extension nicht zu löschen. Die Datei ist im <a href="http://www.christosoft.de/_download/crazystat_current_version" target="_blank">CrazyStat-Downbload</a> enthalten.');

// index.php  (manches auch in index.php genutzt)
define('L_INDEX_WELCOME','Herzlich willkommen!');
define('L_INDEX_THIS_IS_CRAZYSTAT','Dies ist CrazyStat, ein komfortables, umfangreiches und kostenloses PHP-Statistik-Script mit optionalem Counter.');
define('L_INDEX_INFORMATION','Infos und Updates zu CrazyStat finden Sie unter:');
define('L_INDEX_INSTALLED_VERSION','Installierte Version:');
define('L_INDEX_CURRENT_VERSION','Aktuelle Version:');
define('L_INDEX_NEWS','News von');

// about.php
define('L_ABOUT_PLEASE_SEE','Bitte benutzen Sie die');
define('L_ABOUT_README','Readme');
define('L_ABOUT_FAQ','FAQ');
define('L_ABOUT_FOR_HELP','als Hilfe.');

// password_protect.php and index.php
define('L_LOGIN_MENU_HOME','Home');
define('L_LOGIN_MENU_LOGIN','Login');
define('L_LOGIN_MENU_CHANGE_PASSWORD','Passwort ändern');

// calendar.php
define('L_CALENDAR_TITLE','Zeitraum bestimmen');
define('L_CALENDAR_MSG_ERR_YEAR_INVALID','Bitte Jahr nur mit Ziffern angeben!');
define('L_CALENDAR_MSG_ERR_MONTH_ONLY','Fehler. Beschränkung auf einen Monat in allen Jahren ist nicht mehr möglich!');
define('L_CALENDAR_MSG_ERR_NO_JS','Da Sie keinen JavaScript-fähigen Browser verwenden oder JavaScript deaktiviert ist, müssen Sie zum Fortfahren noch einmal klicken:');
define('L_CALENDAR_LIMIT_YEAR','Einschränken auf Jahr');
define('L_CALENDAR_LIMIT_MONTH','Einschränken auf Monat');
define('L_CALENDAR_LIMIT_PERIOD','Einschränken auf Zeitspanne');
define('L_CALENDAR_MONTH_ABR','Jan Feb Mär Apr Mai Jun Jul Aug Sep Okt Nov Dez');
define('L_CALENDAR_MONTH_NAMES','Januar Februar März April Mai Juni Juli August September Oktober November Dezember');
define('L_CALENDAR_WEEKDAYS_ABR','S M D M D F S');
define('L_CALENDAR_WEEKDAYS','Sonntag Montag Dienstag Mittwoch Donnerstag Freitag Samstag');
define('L_CALENDAR_TODAY','Heute');
define('L_CALENDAR_WEEK_START_DAY',1);
define('L_CALENDAR_START','Start');
define('L_CALENDAR_END','Ende');
define('L_CALENDAR_RELATIVE','Relativ');
define('L_CALENDAR_ABSOLUTE','Absolut');
define('L_CALENDAR_RELATIVE_PRESET','Preset');
define('L_CALENDAR_RELATIVE_CUSTOM','Benutzerdefiniert');
define('L_CALENDAR_RELATIVE_THIS_WEEK','Diese Woche');
define('L_CALENDAR_RELATIVE_THIS_MONTH','Diesen Monat');
define('L_CALENDAR_RELATIVE_THIS_YEAR','Dieses Jahr');
define('L_CALENDAR_RELATIVE_CHECK','Prüfen');
define('L_CALENDAR_RELATIVE_HELP','Bitte lesen Sie in der Hilfedatei nach, wie dies funktioniert.');

// create_counter_image.php
define('L_COUNTER_FILE_NOT_FOUND','Countergrafik nicht gefunden');
define('L_COUNTER_GIF_NOT_SUPPORTED','gif-Dateien nicht unterstützt');
define('L_COUNTER_TYPE_NOT_SUPPORTED','Dateityp nicht unterstützt');

// nojs.php
define('L_NOJS_TITLE','Kein JavaScript');
define('L_NOJS_TEXT',
' <p>Leider unterstützt Ihr Browser kein JavaScript. Bitte verwenden Sie einen JavaScript-fähigen Browser, z.B. <a href="http://www.mozilla.com/">Firefox</a>, oder aktivieren Sie JavaScript in Ihrem Browser.</p>
  <p>Eventuell kam es auch zu einem Fehler in einem JavaScript. Sollte Ihr Browser JavaScript unterstützen und dies aktiviert sein, so gehen Sie zurück und versuchen es erneut.</p>
  <p>
  Das Problem kann auch auftreten, wenn ein JavaScript ausgeführt werden soll, obwohl die Seite noch nicht ganz geladen ist.<br />
  Gehen Sie in diesem Fall zurück, lassen die Seite komplett laden und klicken dann erneut auf das Icon, welches Sie angeklickt haben.
  </p>');
  
// stat.php
define('L_STAT_MSG_ERR_COUNTER_FILE','korrupt oder RC?');
define('L_STAT_MSG_ERR_READ_ERROR','Lesefehler (Rechte?)');
define('L_STAT_MSG_ERR_WRITE_ERROR','Schreibfehler(Rechte)');

// analyze.php
define('L_ANALYZE_MSG_OK_CACHE_EXISTED','Es existierte eine Cache-Datei für die Logs im neu angelegten Ordner. Diese wurde gelöscht.');
define('L_ANALYZE_MSG_ERR_LOGFOLDER_INEXISTENT','Der Ordner, indem die Logdateien liegen sollen existiert nicht');
define('L_ANALYZE_MSG_ERR_CREATE_FOLDER','Ordner anlegen');
define('L_ANALYZE_MSG_ERR_FILE_CREATION_FAILED','Die Datei konnte nicht erstellt werden');
define('L_ANALYZE_MSG_ERR_FILE_NOT_FOUND','Die Log-Datei konnte nicht gefunden werden. Versuchen Sie den Cache zu löschen.');
define('L_ANAYLZE_MSG_ERR_CHECK_RIGHTS','Bitte überprüfen Sie "usr/config.php" und die Rechte des Ordners in dem die Logdateien liegen.');
define('L_ANAYLZE_MSG_ERR_CACHE_NOT_DELETED','Eine Cache-Datei konnten nicht gelöscht werden. Bitte überprüfen Sie die Rechte.');
define('L_ANALYZE_UNKNOWN_FILE','Unbekannt');
define('L_ANALYZE_UNKNOWN_SYSTEM','Sonstige');
define('L_ANALYZE_UNKNOWN_BROWSER','Sonstige');
define('L_ANALYZE_UNKNOWN_RESOLUTION','kein JavaScript');
define('L_ANALYZE_UNSAVED','Nicht gespeichert');
define('L_ANALYZE_MSG_ERR_COUNTERFILE_INEXISTENT','Counter-Logdatei konnte nicht gelesen werden. Versuche neue zu erstellen.');
define('L_ANALYZE_MSG_ERR_COUNTERFILE_CREATION_FAILED','Erstellen fehlgeschlagen (Rechte?). Es sind keine Daten verloren gegangen, CrazyStat arbeitet lediglich ineffinzient. Siehe FAQ.');
define('L_ANALYZE_MSG_OK_COUNTERILE_CREATED','Erstellen der Counter-Logdatei erfolgreich. Dies stellt kein Problem dar, es sind keine Daten verloren gegangen.');
define('L_ANALYZE_MSG_ERR_CACHE_SAVE_FAILED','konnte nicht zum Schreiben geöffnet werden. Überprüfen Sie den CHMOD (siehe <a href="../doc/README_de.html" target="_blank">README_de.html</a>).');
define('L_ANALYZE_MSG_ERR_INCOMPLETE','Die Statistik konnte nicht vollständig ausgewertet werden.');
define('L_ANALYZE_MSG_ERR_TIMEOUT','Eventuell wurde die maximale Ausführzeit überschritten (Fehler "Fatal error: Maximum execution time of ... seconds exceeded"). Dies ist eine Beschränkung auf Ihrem Server. CrazyStat kann in diesem Fall mit dem Auswerten der Statistik fortfahren. Es kann sein, dass sie mehrmals "Fortfahren" klicken müssen.');
define('L_ANALYZE_MSG_ERR_MEMORY_LIMIT','Möglichweise wurde das RAM-Limit erreicht (Fehler "Allowed memory size of ... exhausted"). Versuchen Sie in diesem Fall, <a href="../doc/config_settings_de.html#config_stat_memory_limit">$config_stat_memory_limit</a> zu erhöhen.');
define('L_ANALYZE_MSG_ERR_UNKNOWN_ERROR','Wahrscheinlich ist ein Fehler aufgetreten (siehe evtl. Fehlermeldungen oben). Möglicherweise (unwahrscheinlich) wurde auch die maximale Ausführzeit oder das RAM-Limit überschritten. CrazyStat kann versuchen, mit der Auswertung fortzufahren.');
define('L_ANALYZE_MSG_ERR_CURRENT_POSITION','Aktuelle Position');
define('L_ANALYZE_MSG_ERR_GUEST_CLEAR_CACHE','Sie haben keine Berechtigung, den Cache zu löschen. Siehe <a href="../doc/config_settings_de.html#config_stat_guest_cache_delete" target="_blank">$config_stat_guest_cache_delete</a> bzw. <a href="../doc/config_settings_de.html#config_stat_user_cache_delete" target="_blank">$config_stat_user_cache_delete</a>.');
define('L_ANALYZE_MSG_ERR_CACHE_BROKEN','Eine Cache-Datei scheint beschädigt zu sein. Bitte tun Sie folgendes um das Problem zu lösen:');

// show_log.php
define('L_SHOWLOG_TITLE','Log');
define('L_SHOWLOG_ALLLOGS','Alle Logdateien');
define('L_SHOWLOG_MSG_ERR_INVALID_ID','Die übermittelte ID ist ungültig.');
define('L_SHOWLOG_MSG_ERR_LOGFILE_NOTFOUND','Die Logdatei, die angezeigt werden soll, existiert nicht. Bitte überprüfen Sie ob die folgende Datei existiert:');
define('L_SHOWLOG_END_OF_LOGFILE','Ende der Logdatei');
define('L_SHOWLOG_NEXT_LOGFILE','Nächste Logdatei');
define('L_SHOWLOG_PREV_LOGFILE','Vorherige Logdatei');
define('L_SHOWLOG_PREV_PAGE','Vorherige Seite');
define('L_SHOWLOG_NEXT_PAGE','Nächste Seite');
define('L_SHOWLOG_PAGE','Seite');
define('L_SHOWLOG_FORWARD','Vorwärts');
define('L_SHOWLOG_BACKWARD','Rückwärts');
define('L_SHOWLOG_TEXT','Text');
define('L_SHOWLOG_TABLE','Tabelle');
define('L_SHOWLOG_FILTERED','gefiltert');
define('L_SHOWLOG_ROWS_FOUND','Zeile(n) gefunden');

// logs.php
define('L_LOGS_SEARCH_CONTAINS','enthält');
define('L_LOGS_SEARCH_CONTAINS_NOT','enth. nicht');
define('L_LOGS_SEARCH_UNEQUAL','ungleich');
define('L_LOGS_VALUE','Wert');
define('L_LOGS_TITLE','Logdateien');
define('L_LOGS_BACKUP','Backup');
define('L_LOGS_VIEW','Ansicht');
define('L_LOGS_FILTER_TITLE','Logs durchsuchen (Filter)');
define('L_LOGS_ADD_CONDITION','Weitere Bedingung');
define('L_LOGS_SEARCH_SUBMIT','Suchen');
define('L_LOGS_SEARCH_WAIT','Logs werden durchsucht. Bitte warten...');
define('L_LOGS_MSG_ERR_NOFILE','Keine Datei ausgewählt..');
define('L_LOGS_MSG_CONFIM_DELETE','Sollen die folgenden Dateien wirklich unwiderruflich gelöscht werden?');
define('L_LOGS_SEARCH','Suchen');
define('L_LOGS_SELECT_ALL','Alle auswählen');
define('L_LOGS_SELECT_NONE','Auswahl entfernen');
define('L_LOGS_SELECTED','markierte');
define('L_LOGS_MSG_ERR_GUEST_DOWNLOAD','Sie sind nicht berechtigt Logdateien herunterzuladen. Siehe <a href="../doc/config_settings_de.html#config_stat_guest_log_download" target="_blank">$config_stat_guest_log_download</a> sowie <a href="../doc/config_settings_de.html#config_stat_user_log_download" target="_blank">$config_stat_user_log_download</a>.');
define('L_LOGS_MSG_ERR_GUEST_DELETE','Sie sind nicht berechtigt Logdateien zu löschen. Siehe <a href="../doc/config_settings_de.html#config_stat_guest_log_delete" target="_blank">$config_stat_guest_log_delete</a> sowie <a href="../doc/config_settings_de.html#config_stat_user_log_delete" target="_blank">$config_stat_user_log_delete</a>.');

// show_stat.php
define('L_SHOWSTAT_PRESETS','Presets');
define('L_SHOWSTAT_PRESETS_DEFAULT','Default');
define('L_SHOWSTAT_PRESETS_DEFAULT_OLD','Default (alt)');
define('L_SHOWSTAT_PRESETS_IP1','IP-Sperren an');
define('L_SHOWSTAT_PRESETS_IP0','IP-Sperren aus');
define('L_SHOWSTAT_PRESETS_PIE_CHARTS','Tortendiagramme');
define('L_SHOWSTAT_PRESETS_BAR_CHARTS','Balkendiagramme');
define('L_SHOWSTAT_PRESETS_THIS_YEAR','Dieses Jahr');
define('L_SHOWSTAT_PRESETS_THIS_MONTH','Diesen Monat');
define('L_SHOWSTAT_PRESETS_ALL','Alle anzeigen (all)');
define('L_SHOWSTAT_PRESETS_LIMIT','Begrenzt anzeigen (limit)');
define('L_SHOWSTAT_PRESETS_SCROLL1','Modul-Scrollbalken ein');
define('L_SHOWSTAT_PRESETS_SCROLL0','Modul-Scrollbalken aus');
define('L_SHOWSTAT_PRESETS_TOTAL_TIME','Gesamte Zeit');
define('L_SHOWSTAT_PRESETS_CURRENT_PERIOD','Aktuelle Periode');
define('L_SHOWSTAT_PRESETS_MANAGE','Presets verwalten');
define('L_SHOWSTAT_CLEAR_CACHE','Cache löschen');
define('L_SHOWSTAT_REFRESH_ALL','Alle aktualisieren');
define('L_SHOWSTAT_LOGS','Logs');
define('L_SHOWSTAT_MSG_OK_WAIT','Die von Ihnen gewünschte Aktion benötigt einen Moment. Eventuell muss die Statistik neu ausgewertet werden, was einige Zeit in Anspruch nimmt.');

// preset-specific
define('L_PRESET_DEFAULT_YEAR','letzte 12 Monate');
define('L_PRESET_DEFAULT_MONTH','ein Monat Zeit');
define('L_PRESET_DEFAULT_WEEK','letzte 7 Tage');
define('L_PRESET_DEFAULT_DAY','letzte 24 Stunden');

// module_out.php
define('L_MODULEOUT_HITS_PI','Gesamt-Seitenaufrufe (Page Impressions)');
define('L_MODULEOUT_HITS_VISITS','Gesamt-Besucher (Visits)');
define('L_MODULEOUT_HITS_THIS_MONTH','Besucher diesen Monat');
define('L_MODULEOUT_HITS_LAST_MONTH','Besucher letzten Monat');
define('L_MODULEOUT_HITS_USER_ONLINE','Besucher online');
define('L_MODULEOUT_HITS_MAX_DAY','Maximum Besucher am');
define('L_MODULEOUT_HITS_AV_PER_DAY','Durchschnitt Besucher/Tag');
define('L_MODULEOUT_HITS_HITS_PER_USER','Durchschnitt Seitenaufrufe/Besucher');
define('L_MODULEOUT_IP0','Seitenaufrufe (ohne IP-Sperre)');
define('L_MODULEOUT_IP1','Besucher (mit IP-Sperre)');
define('L_MODULEOUT_NO_DATA','keine Zugriffe');
define('L_MODULEOUT_TOTAL_TIME','gesamt');
define('L_MODULEOUT_PIE_CHART','Kreisdiagramm');
define('L_MODULEOUT_BAR_CHART','Kreisdiagramm');
define('L_MODULEOUT_SORT_BY','Durch Klick sortieren nach');
define('L_MODULEOUT_SORT_BY_NUM','Durch Klick nach Anzahl sortieren');
define('L_MODULEOUT_SORT_BY_PER','Durch Klick nach Prozent sortieren');
define('L_MODULEOUT_SORT_BY_RATIO','Durch Klick nach Anteil sortieren');
define('L_MODULEOUT_NUM','Anzahl');
define('L_MODULEOUT_NUM_ABR','Anz.');
define('L_MODULEOUT_PER','Proz.');
define('L_MODULEOUT_TOTAL','Gesamt');
define('L_MODULEOUT_RATIO','Anteil');
define('L_MODULEOUT_DOMAINS','Domains');
define('L_MODULEOUT_PAGES','Seiten');
define('L_MODULEOUT_COLORS','Farben');
define('L_MODULEOUT_CONSOLE_REFERSH','Modul aktualisieren');
define('L_MODULEOUT_CONSOLE_REFERSH_ALT','Aktualis.');
define('L_MODULEOUT_CONSOLE_PERIOD','Zeitraum');
define('L_MODULEOUT_CONSOLE_PERIOD_DEFINE','Zeitraum bestimmen');
define('L_MODULEOUT_CLICK_IP1','Klicken für Besucher (IP-Sperre an).');
define('L_MODULEOUT_CLICK_IP0','Klicken für Seitenaufrufe (IP-Sperre aus).');
define('L_MODULEOUT_CONSOLE_ALL','Alle anzeigen');
define('L_MODULEOUT_CONSOLE_ALL_ABR','Alle');
define('L_MODULEOUT_CONSOLE_SHOW_ONLY','Zeige nur');
define('L_MODULEOUT_CONSOLE_TREE_ABR','Baumansicht an');
define('L_MODULEOUT_CONSOLE_TREE','Baumansicht anschalten, Referer nach Hosts ordnen');
define('L_MODULEOUT_CONSOLE_TREE_OFF','Baumansicht abschalten, alle Seiten einzeln listen');
define('L_MODULEOUT_CONSOLE_TREE_OFF_ABR','Baumansicht aus');
define('L_MODULEOUT_CONSOLE_TREE_OTHER','Andere Baum-Extension');
define('L_MODULEOUT_CONSOLE_TREE_COLLAPSE','Alle verbergen');
define('L_MODULEOUT_CONSOLE_TREE_EXPAND','Alle anzeigen');
define('L_MODULEOUT_PRETTYINT_SUFFIX','Milo. Mrd. Billionen Billiarden Trillionen Trilliarden');

// preset_editor.php
define('L_PRESETEDITOR_MANAGE_PRESETS','Presets verwalten');
define('L_PRESETEDITOR_ID','ID');
define('L_PRESETEDITOR_CACHE_SIZE','Cache-Größe');
define('L_PRESETEDITOR_SAVE_PRESET','Preset speichern');
define('L_PRESETEDITOR_SAVE_PRESET_TEXT','Hiermit können alle aktuellen Einstellungen als Preset zur künftigen Verwendung gespeichert werden.');
define('L_PRESETEDITOR_SAVE_PRESET_MSG_ABS','WARNUNG: Die aktuellen Einstellungen enthalten absolute Zeitspannen für folgende Module');
define('L_PRESETEDITOR_SAVE_PRESET_MSG_ABS2','Absolute Zeitspannen als Preset zu speichern macht wenig Sinn!');
define('L_PRESETEDITOR_SAVE_PRESET_DUPLICATE','Die aktuellen Einstellungen entsprechen folgendem Preset:');
define('L_PRESETEDITOR_SAVE_PRESET_DUPLICATE_CANNOT_BE_SAVED','Sie können nur Einstellungen als Preset speichern, welche sich von existierenden Presets unterscheiden.');
define('L_PRESETEDITOR_CACHE','Dieses Preset cachen');
define('L_PRESETEDITOR_CACHE_NOT','Dieses Preset nicht cachen');
define('L_PRESETEDITOR_CACHE_UNCACHEABLE','Cachen dieses Presets nicht möglich');
define('L_PRESETEDITOR_MSG_ERR_GUEST','Sie sind nicht berechtigt, Presets zu verwalten. Siehe <a href="../doc/config_settings_de.html#config_stat_guest_preset_manage" target="_blank">$config_stat_guest_preset_manage</a> bzw. <a href="../doc/config_settings_de.html#config_stat_user_preset_manage" target="_blank">$config_stat_user_preset_manage</a>.');
define('L_PRESETEDITOR_MSG_PRESET_DELETE','Möchten Sie dieses Preset wirklich löschen');
define('L_PRESETEDITOR_MSG_PRESET_DELETED','Preset gelöscht');
define('L_PRESETEDITOR_MSG_PRESET_SAVED','Preset gespeichert');

// anonymous_redirect.php
define('L_ANONYMOUS_REDIRECT','Sie werden anonym weitergeleitet zu:');

// pie_zoom.php
define('L_PIEZOOM_MSG_ERR_NO_DATA','Keine ausgewerteten Daten vorhanden.');

// menu-texts
define('L_MENU_WEBSITE','Website aufrufen');
define('L_MENU_ABOUT','Über CrazyStat');
define('L_MENU_STATISTIC','Zur Statistik');

// modules
define('L_MODULES_HIT_P','Hits');
define('L_MODULES_HIT_S','Hit');
define('L_MODULES_WEEKDAY_P','Wochentage');
define('L_MODULES_WEEKDAY_S','Wochentag');
define('L_MODULES_MONTH_P','Monate');
define('L_MODULES_MONTH_S','Monat');
define('L_MODULES_DAY_P','Tage');
define('L_MODULES_DAY_S','Tag');
define('L_MODULES_HOUR_P','Stunden');
define('L_MODULES_HOUR_S','Stunde');
define('L_MODULES_BROWSER_P','Browser');
define('L_MODULES_BROWSER_S','Browser');
define('L_MODULES_FILE_P','Dateien');
define('L_MODULES_FILE_S','Datei');
define('L_MODULES_RESOLUTION_P','Auflösungen');
define('L_MODULES_RESOLUTION_S','Auflösung');
define('L_MODULES_COLORDEPTH_P','Farbtiefen');
define('L_MODULES_COLORDEPTH_S','Farbtiefe');
define('L_MODULES_SYSTEM_P','Systeme');
define('L_MODULES_SYSTEM_S','System');
define('L_MODULES_REFERER_P','Referer');
define('L_MODULES_REFERER_S','Referer');
define('L_MODULES_KEYWORD_P','Suchbegriffe');
define('L_MODULES_KEYWORD_S','Suchbegriff');

// general error messages
define('L_MSG_ERR_INCLUDE_ONLY','Diese Datei kann nicht direkt aufgerufen werden.');
define('L_MSG_ERR_NO_MODULE','Kein Modul übermittelt oder Modul nicht gefunden.');
define('L_MSG_ERR','Fehler');
define('L_MSG_ERR_CONTINUE','Fortfahren');

// general texts
define('L_LOGOUT','Logout');
define('L_CLOSE','Schließen');
define('L_OK','OK');
define('L_NUMBER','Nr.');
define('L_TIME','Zeit');
define('L_DATE','Datum');
define('L_IP','IP');
define('L_USERAGENT','User Agent');
define('L_BIT','Bit');
define('L_DATE_FORMAT','d.m.Y');
define('L_TIME_FORMAT','H:i:s');
define('L_GO','Go');
define('L_PLEASE_WAIT','Bitte warten ...');
define('L_HITS','Hits');
define('L_VISITS','Besucher');
define('L_PAGEIMPRESSIONS','Seitenaufrufe');
define('L_BACK','Zurück');
define('L_CANCEL','Abbrechen');
define('L_DELETE','Löschen');
define('L_REFRESH','Aktualisieren');
define('L_AND','und');
define('L_LANGUAGE','Sprache');
define('L_NAME','Name');

?>