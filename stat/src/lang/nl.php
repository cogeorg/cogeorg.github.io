<?php
// password_protect.php
define('L_PASSWORD_MES_ERR_NEW_INVALID','Nieuw wachtwoord ontbreekt of komt niet overeen met de herhaling.');
define('L_PASSWORD_MES_ERR_NOT_CHANGED','Wachtwoord is niet veranderd!');
define('L_PASSWORD_MES_ERR_RETRY','Opnieuw proberen');
define('L_PASSWORD_MES_ERR_WRITING_FAILED','Wachtwoord-bestand kon niet geopend worden voor bewerking. Kijk alstublieft de rechten (CHMOD of write lock) van het bestand na.');
define('L_PASSWORD_MES_OK_CHANGED','Uw wachtwoord is veranderd!');
define('L_PASSWORD_MES_ERR_NOT_LOGGED_IN','Sessie verlopen of niet ingelogd.');
define('L_PASSWORD_MES_ERR_RELOGIN','Opnieuw inloggen');

define('L_PASSWORD_PLEASE_LOGIN','Inloggen alstublieft');
define('L_PASSWORD_USERNAME','Gebruikersnaam');
define('L_PASSWORD_PASSWORD','Wachtwoord');
define('L_PASSWORD_DO_NOT_COUNT','Aantal bezoeken van deze computer niet meetellen');
define('L_PASSWORD_PLEASE_WAIT','Een ogenblik geduld alstublieft');
define('L_PASSWORD_MES_ERR_WRONG_DATA','Gebruikersnaam of wachtwoord onjuist. Toegang geweigerd.');
define('L_PASSWORD_MES_OK_THANK_YOU','Bedankt voor het gebruiken van CrazyStat!');
define('L_PASSWORD_MES_SUPPORT_CRAZYSTAT','<a href="http://en.christosoft.de/Support">Ondersteun CrazyStat!</a>');
define('L_PASSWORD_NO_JAVASCRIPT','Waarschuwing! Het wachtwoord zal onbeveiligd worden verzonden, omdat uw browser geen JavaScript ondersteunt!');
define('L_PASSWORD_CHANGE_PASSWORD','Wachtwoord veranderen');
define('L_PASSWORD_OLD_PASSWORD','Oud wachtwoord');
define('L_PASSWORD_NEW_PASSWORD','Nieuw wachtwoord');
define('L_PASSWORD_REPEAT_PASSWORD','Nieuw wachtwoord herhalen');
define('L_PASSWORD_CHANGE_AND_LOGIN','Opslaan en inloggen');
define('L_PASSWORD_MSG_ERR_NOMD5','Waarschuwing! Het nieuwe wachtwoord zal onbeveiligd worden verzonden, omdat $config_stat_password_md5 is ingesteld op false.<br />Om het wachtwoord veilig op te slaan, dient u deze te veranderen in true. (zie onze FAQ).');
define('L_PASSWORD_MSG_ERR_NO_MD5JS','Waarschuwing! Het nieuwe wachtwoord zal onbeveiligd worden verzonden, omdat het bestand src/extensions/md5.js ontbreekt. Wij raden u aan deze extensie niet te verwijderen. U kunt het ontbrekende bestand vinden in het <a href="http://en.christosoft.de/_download/crazystat_current_version" target="_blank">CrazyStat download-bestand</a>.');

// index.php (some used by about.php as well)
define('L_INDEX_WELCOME','Welkom!');
define('L_INDEX_THIS_IS_CRAZYSTAT','Dit is CrazyStat, een comfortabel, uitgebreid en gratis statistieken-script met optionele counter.');
define('L_INDEX_INFORMATION','Informatie en updates vindt u op:');
define('L_INDEX_INSTALLED_VERSION','Geïnstalleerde versie:');
define('L_INDEX_CURRENT_VERSION','Nieuwste versie:');
define('L_INDEX_NEWS','Nieuws op');

// about.php
define('L_ABOUT_PLEASE_SEE','Zie');
define('L_ABOUT_README','Readme');
define('L_ABOUT_FAQ','FAQ');
define('L_ABOUT_FOR_HELP','voor hulp.');

// password_protect.php and index.php
define('L_LOGIN_MENU_HOME','Startpagina');
define('L_LOGIN_MENU_LOGIN','Inloggen');
define('L_LOGIN_MENU_CHANGE_PASSWORD','Wachtwoord veranderen');

// calendar.php
define('L_CALENDAR_TITLE','Periode definiëren');
define('L_CALENDAR_MSG_ERR_YEAR_INVALID','Ongeldig jaar, zorg er alstublieft voor dat u cijfers gebruikt.');
define('L_CALENDAR_MSG_ERR_MONTH_ONLY','Fout: selecteer een maand alstublieft <i>and</i> year.');
define('L_CALENDAR_MSG_ERR_NO_JS','Als uw brouwser geen JavaScript ondersteunt of als u deze optie heeft uigeschakeld, dient u zelf te klikken om verder te gaan:');
define('L_CALENDAR_LIMIT_YEAR','Grenswaarde per jaar');
define('L_CALENDAR_LIMIT_MONTH','Grenswaarde per maand');
define('L_CALENDAR_LIMIT_PERIOD','Grenswaarde per periode');
define('L_CALENDAR_MONTH_ABR','jan feb mrt apr mei jun jul aug sep okt nov dec');
define('L_CALENDAR_MONTH_NAMES','januari februari maart april mei juni juli augustus september oktober november december');
define('L_CALENDAR_WEEKDAYS_ABR','Z M D W D V Z');
define('L_CALENDAR_WEEKDAYS','zondag maandag dinsdag woensdag donderdag vrijdag zaterdag');
define('L_CALENDAR_TODAY','Vandaag');
define('L_CALENDAR_WEEK_START_DAY',0);
define('L_CALENDAR_START','Begin');
define('L_CALENDAR_END','Einde');
define('L_CALENDAR_RELATIVE','Relatief');
define('L_CALENDAR_ABSOLUTE','Absoluut');
define('L_CALENDAR_RELATIVE_PRESET','Vooraf ingesteld');
define('L_CALENDAR_RELATIVE_CUSTOM','Aangepast');
define('L_CALENDAR_RELATIVE_THIS_WEEK','Deze week');
define('L_CALENDAR_RELATIVE_THIS_MONTH','Deze maand');
define('L_CALENDAR_RELATIVE_THIS_YEAR','Dit jaar');
define('L_CALENDAR_RELATIVE_CHECK','Controleren');
define('L_CALENDAR_RELATIVE_HELP','Lees alstublieft het help-bestand voor meer informatie.');

// create_counter_image.php
define('L_COUNTER_FILE_NOT_FOUND','Ontwerp van teller niet gevonden');
define('L_COUNTER_GIF_NOT_SUPPORTED','Gif-bestanden worden niet ondersteunt');
define('L_COUNTER_TYPE_NOT_SUPPORTED','Bestandstype wordt niet ondersteunt');

// nojs.php
define('L_NOJS_TITLE','JavaScript ontbreekt');
define('L_NOJS_TEXT',
' <p>Helaas ondersteunt uw browser geen JavaScript of heeft u deze optie uitgeschakeld . Wij raden u aan een browser te gebruiken die wel JavaScript ondersteuning geeft, bijv. <a href="http://www.mozilla.com/">Firefox</a>, of deze optie in te schakelen als u deze zelf heeft uitgeschakeld.</p>
  <p>In sommige gevallen verschijnt dit bericht er een fout is opgetrenden in het JavaScript. Als uw browser JavaScript ondersteunt en deze optie is ingeschakeld , willen wij u verzoeken terug te gaan en het nogmaals proberen.</p>
  <p>
  Daarnaast is het mogelijk dat u dit bericht ziet als een JavaScript op de website nog niet volledig is geladen.<br />
  Als dit het geval is, verzoeken wij u terug te keren naar de vorige pagina en nogmaals op het icoon te klikken.
  </p>');
  
// stat.php
define('L_STAT_MSG_ERR_COUNTER_FILE','corrupt or RC?');
define('L_STAT_MSG_ERR_READ_ERROR','Leesfout (Rechten?)');
define('L_STAT_MSG_ERR_WRITE_ERROR','Schrijffout (Rechten?)');

// analyze.php
define('L_ANALYZE_MSG_OK_CACHE_EXISTED','Er bevond zich een cache-bestand voor het logboek in de nieuw aangemaakte map. Dit cache-bestand is verwijderd.');
define('L_ANALYZE_MSG_ERR_LOGFOLDER_INEXISTENT','De map waarin u dit bestand wilt plaatsen bestaat niet.');
define('L_ANALYZE_MSG_ERR_CREATE_FOLDER','Map aanmaken');
define('L_ANALYZE_MSG_ERR_FILE_CREATION_FAILED','Het bestand kon niet worden aangemaakt');
define('L_ANALYZE_MSG_ERR_FILE_NOT_FOUND','Het Log-bestand kon niet gevonden worden. Wij adviseren uw cache op te schonen.');
define('L_ANAYLZE_MSG_ERR_CHECK_RIGHTS','Kijk alstublieft het bestand "usr/config.php" na en zorg ervoor dat de map waarin het logbestand zal worden opgeslagen, de juiste rechten heeft. .');
define('L_ANAYLZE_MSG_ERR_CACHE_NOT_DELETED','Het cache-bestand kon niet worden verwijderd. Kijk alstublieft de rechten na.');
define('L_ANALYZE_UNKNOWN_FILE','Onbekend');
define('L_ANALYZE_UNKNOWN_SYSTEM','Anders');
define('L_ANALYZE_UNKNOWN_BROWSER','Anders');
define('L_ANALYZE_UNKNOWN_RESOLUTION','geen JavaScript');
define('L_ANALYZE_UNSAVED','Niet opgeslagen');
define('L_ANALYZE_MSG_ERR_COUNTERFILE_INEXISTENT','Teller-bestand kon niet worden gelezen. Proberen een nieuwe aan te maken.');
define('L_ANALYZE_MSG_ERR_COUNTERFILE_CREATION_FAILED','Aanmaken mislukt (rechten?). Er zijn geen gegevens verloren gegaan, maar CrazyStat werkt niet optimaal. Zie FAQ.');
define('L_ANALYZE_MSG_OK_COUNTERILE_CREATED','Teller-bestand succesvol aangemaakt. Dit geeft geen problemen, er zijn geen gevens verloren gegaan.');
define('L_ANALYZE_MSG_ERR_CACHE_SAVE_FAILED','Kan niet worden geopend voor bewerking. Kijk de rechten na (CHMOD - raadpleeg <a href="../doc/README_en.html" target="_blank">README_en.html</a>).');
define('L_ANALYZE_MSG_ERR_INCOMPLETE','De statistieken konden niet volledig worden gegenereerd.');
define('L_ANALYZE_MSG_ERR_TIMEOUT','Waarschijnlijk werd de maximale uitvoeringstermijn overschreden ("Fatal error: Maximum execution time of ... seconds exceeded"). Dit termijnlimiet is te wijten aan uw server. CrazyStat kan verder gaan met het genereren van uw statistieken. Het kan voorkomen dat u meerdere malen op \'Continue\' dient te drukken.');
// todo: translate
define('L_ANALYZE_MSG_ERR_MEMORY_LIMIT','Probably the memory-limit was exceeded ("Allowed memory size of ... exhausted"). In this case, try to increase <a href="../doc/config_settings_en.html#config_stat_memory_limit">$config_stat_memory_limit</a>.');
// todo: tranlate "or the memory limit was exceeded"
define('L_ANALYZE_MSG_ERR_UNKNOWN_ERROR','Het lijkt er op dat er een fout is opgetreden (elke foutmelding hierboven?). Mogelijk (onwaarschijnlijk) is het uitvoeringstermijn overschreden (or the memory limit was exceeded). CrazyStat kan proberen door te gaan met het genereren van de statistieken.');
define('L_ANALYZE_MSG_ERR_CURRENT_POSITION','Huidige positie');
define('L_ANALYZE_MSG_ERR_GUEST_CLEAR_CACHE','U bent niet bevoegd het cache bestand op te schonen. Raadpleeg <a href="../doc/config_settings_en.html#config_stat_guest_cache_delete" target="_blank">$config_stat_guest_cache_delete</a> en <a href="../doc/config_settings_en.html#config_stat_user_cache_delete" target="_blank">$config_stat_user_cache_delete</a>.');
define('L_ANALYZE_MSG_ERR_CACHE_BROKEN','Het lijkt erop dat het cache-bestand beschadigd is. Het volgende is een mogelijke oplossing:');

// show_log.php
define('L_SHOWLOG_TITLE','Log');
define('L_SHOWLOG_ALLLOGS','Alle logbestanden');
define('L_SHOWLOG_MSG_ERR_INVALID_ID','Er is geen logbestand bekend bij dit id.');
define('L_SHOWLOG_MSG_ERR_LOGFILE_NOTFOUND','Het opgevraagde logbestand bestaat niet. Controleer alstublieft of het volgende bestand bestaat:');
define('L_SHOWLOG_END_OF_LOGFILE','Einde van het logbestand');
define('L_SHOWLOG_NEXT_LOGFILE','Volgend logbestand');
define('L_SHOWLOG_PREV_LOGFILE','Vorig logbestand');
define('L_SHOWLOG_PREV_PAGE','Vorige pagina');
define('L_SHOWLOG_NEXT_PAGE','Volgende pagina');
define('L_SHOWLOG_PAGE','Pagina');
define('L_SHOWLOG_FORWARD','Vooruit');
define('L_SHOWLOG_BACKWARD','Achteruit');
define('L_SHOWLOG_TEXT','Tekst');
define('L_SHOWLOG_TABLE','Tabel');
define('L_SHOWLOG_FILTERED','Gefilterd');
define('L_SHOWLOG_ROWS_FOUND','Rij(en) gevonden');

// logs.php
define('L_LOGS_SEARCH_CONTAINS','bevat');
define('L_LOGS_SEARCH_CONTAINS_NOT','bevat niet');
define('L_LOGS_SEARCH_UNEQUAL','ongelijk');
define('L_LOGS_VALUE','Waarde');
define('L_LOGS_TITLE','Log bestanden');
define('L_LOGS_BACKUP','Backup');
define('L_LOGS_VIEW','Bekijk');
define('L_LOGS_FILTER_TITLE','Zoek in logbestanden (filter)');
define('L_LOGS_ADD_CONDITION','Voorwaarde toevoegen');
define('L_LOGS_SEARCH_SUBMIT','Zoeken');
define('L_LOGS_SEARCH_WAIT','Er wordt gezocht... Een ogenblik geduld alstublieft.');
define('L_LOGS_MSG_ERR_NOFILE','Er is geen bestand geselecteerd.');
define('L_LOGS_MSG_CONFIM_DELETE','Weet u zeker dat u de volgende bestanden permanent wilt verwijderen?');
define('L_LOGS_SEARCH','Zoeken');
define('L_LOGS_SELECT_ALL','Alles selecteren');
define('L_LOGS_SELECT_NONE','Selectie ongedaan maken');
define('L_LOGS_SELECTED','Geselecteerd');
define('L_LOGS_MSG_ERR_GUEST_DOWNLOAD','U bent niet bevoegd logbestanden te downloaden. Raadpleeg <a href="../doc/config_settings_en.html#config_stat_guest_log_download" target="_blank">$config_stat_guest_log_download</a> en <a href="../doc/config_settings_en.html#config_stat_user_log_download" target="_blank">$config_stat_user_log_download</a>.');
define('L_LOGS_MSG_ERR_GUEST_DELETE','U bent niet bevoegd logbestanden te verwijderen. Raadpleeg <a href="../doc/config_settings_en.html#config_stat_guest_log_delete" target="_blank">$config_stat_guest_log_delete</a> en <a href="../doc/config_settings_en.html#config_stat_user_log_delete" target="_blank">$config_stat_user_log_delete</a>.');

// show_stat.php
define('L_SHOWSTAT_PRESETS','Voorkeuren');
define('L_SHOWSTAT_PRESETS_DEFAULT','Standaard');
define('L_SHOWSTAT_PRESETS_DEFAULT_OLD','Oude standaard');
define('L_SHOWSTAT_PRESETS_IP1','Blokkeren op IP');
define('L_SHOWSTAT_PRESETS_IP0','Niet blokkeren op IP');
define('L_SHOWSTAT_PRESETS_PIE_CHARTS','Cirkeldiagrammen');
define('L_SHOWSTAT_PRESETS_BAR_CHARTS','Staafdiagrammen');
define('L_SHOWSTAT_PRESETS_THIS_YEAR','Dit jaar');
define('L_SHOWSTAT_PRESETS_THIS_MONTH','Deze maand');
define('L_SHOWSTAT_PRESETS_ALL','Alles tonen');
define('L_SHOWSTAT_PRESETS_LIMIT','Alleen de eerste laten zien');
define('L_SHOWSTAT_PRESETS_SCROLL1','Module-scrollbalken aan');
define('L_SHOWSTAT_PRESETS_SCROLL0','Module-scrollbalken uit');
define('L_SHOWSTAT_PRESETS_TOTAL_TIME','Totale tijd');
define('L_SHOWSTAT_PRESETS_CURRENT_PERIOD','Huidige periode');
define('L_SHOWSTAT_PRESETS_MANAGE','Voorkeurinstellingen beheren');
define('L_SHOWSTAT_CLEAR_CACHE','Cache opschonen');
define('L_SHOWSTAT_REFRESH_ALL','Alles vernieuwen');
define('L_SHOWSTAT_LOGS','Logbestanden');
define('L_SHOWSTAT_MSG_OK_WAIT','De uitgevoerde actie duurt even. Dit komt waarschijnlijk doordat de statistieken opnieuw gegenereerd moeten worden.');

// preset-specific
define('L_PRESET_DEFAULT_YEAR','laatste 12 maanden');
define('L_PRESET_DEFAULT_MONTH','Per maand');
define('L_PRESET_DEFAULT_WEEK','Laatste 7 dagen');
define('L_PRESET_DEFAULT_DAY','Laatste 24 uur');

// module_out.php
define('L_MODULEOUT_HITS_PI','Totale paginaweergaven');
define('L_MODULEOUT_HITS_VISITS','Totale bezoekers');
define('L_MODULEOUT_HITS_THIS_MONTH','Huidige maand bezocht');
define('L_MODULEOUT_HITS_LAST_MONTH','Vorige maand bezocht');
define('L_MODULEOUT_HITS_USER_ONLINE','Gebruiker online');
define('L_MODULEOUT_HITS_MAX_DAY','Maximale bezoeken per dag');
define('L_MODULEOUT_HITS_AV_PER_DAY','Gemiddelde bezoeken per dag');
define('L_MODULEOUT_HITS_HITS_PER_USER','Gemiddelde paginaweergaven per bezoeker');
define('L_MODULEOUT_IP0','Paginaweergaven (Niet geblokkeerd op IP)');
define('L_MODULEOUT_IP1','Aantal Bezoeken (Geblokkeerd op IP)');
define('L_MODULEOUT_NO_DATA','geen gegevens');
define('L_MODULEOUT_TOTAL_TIME','totale tijd');
define('L_MODULEOUT_PIE_CHART','Cirkeldiagram');
define('L_MODULEOUT_BAR_CHART','Staafdiagram');
define('L_MODULEOUT_SORT_BY','Klik hier om te sorteren op');
define('L_MODULEOUT_SORT_BY_NUM','Klik hier om op nummer te sorteren');
define('L_MODULEOUT_SORT_BY_PER','Klik hier om op percentage te sorteren');
define('L_MODULEOUT_SORT_BY_RATIO','Klik hier om op ratio te sorteren');
define('L_MODULEOUT_NUM','Aantal');
define('L_MODULEOUT_NUM_ABR','Cijf.');
define('L_MODULEOUT_PER','Perc.');
define('L_MODULEOUT_TOTAL','Totaal');
define('L_MODULEOUT_RATIO','Ratio');
define('L_MODULEOUT_DOMAINS','Domeinen');
define('L_MODULEOUT_PAGES','Pagina\'s');
define('L_MODULEOUT_COLORS','kleuren');
define('L_MODULEOUT_CONSOLE_PERIOD','Periode');
define('L_MODULEOUT_CONSOLE_PERIOD_DEFINE','Definieer periode');
define('L_MODULEOUT_CLICK_IP1','Klik hier voor bezoekers (Geblokkeerd op IP).');
define('L_MODULEOUT_CLICK_IP0','Klik hier voor paginaweergaven (Niet geblokkeerd op IP).');
define('L_MODULEOUT_CONSOLE_ALL','Alles tonen');
define('L_MODULEOUT_CONSOLE_ALL_ABR','Alles');
define('L_MODULEOUT_CONSOLE_SHOW_ONLY','Toon alleen');
define('L_MODULEOUT_CONSOLE_TREE_ABR','Schakel boomstructuur in');
define('L_MODULEOUT_CONSOLE_TREE','Schakel boomstructuur in en sorteer verwijzers op host');
define('L_MODULEOUT_CONSOLE_TREE_OFF','Schakel boomstructuur uit, catalogiseer alle verwijzers');
define('L_MODULEOUT_CONSOLE_TREE_OFF_ABR','Schakel boomstructuur uit');
define('L_MODULEOUT_CONSOLE_TREE_OTHER','Wijzig uiterlijk');
define('L_MODULEOUT_CONSOLE_TREE_COLLAPSE','Inklappen');
define('L_MODULEOUT_CONSOLE_TREE_EXPAND','Uitklappen/uitbreiden');
define('L_MODULEOUT_PRETTYINT_SUFFIX','m bn trillion quadrillion quintillion sextillion');

// preset_editor.php
define('L_PRESETEDITOR_MANAGE_PRESETS','Voorkeursinstellingen beheren');
define('L_PRESETEDITOR_ID','ID');
define('L_PRESETEDITOR_CACHE_SIZE','Cache grootte');
define('L_PRESETEDITOR_SAVE_PRESET','Voorkeursinstellingen opslaan');
define('L_PRESETEDITOR_SAVE_PRESET_TEXT','Hierdoor worden de huidige instellingen opgeslagen (all of them) als toekomstige voorkeursinstellingen. Alle intellingen worden automatisch gedetecteerd.');
define('L_PRESETEDITOR_SAVE_PRESET_MSG_ABS','WAARSCHUWING: Uw huidige instellingen bevatten absolute periodes voor de volgende module(s)');
define('L_PRESETEDITOR_SAVE_PRESET_MSG_ABS2','Het is niet nuttig absolute periodes op te slaan als voorkeur!');
define('L_PRESETEDITOR_SAVE_PRESET_DUPLICATE','Deze voorkeursinstelling is gelijk aan:');
define('L_PRESETEDITOR_SAVE_PRESET_DUPLICATE_CANNOT_BE_SAVED','U kunt enkel unieke voorkeursinstellingen opslaan.');
define('L_PRESETEDITOR_CACHE','Voorkeursinstelling opslaan in cache');
define('L_PRESETEDITOR_CACHE_NOT','Voorkeursinstelling niet opslaan in cache');
define('L_PRESETEDITOR_CACHE_UNCACHEABLE','Deze voorkeursinstelling kan niet worden toegevoegd aan het cache');
define('L_PRESETEDITOR_MSG_ERR_GUEST','U bent niet bevoegd voorkeursinstellingen te wijzigen. Zie <a href="../doc/config_settings_en.html#config_stat_guest_preset_manage" target="_blank">$config_stat_guest_preset_manage</a> en <a href="../doc/config_settings_en.html#config_stat_user_preset_manage" target="_blank">$config_stat_user_preset_manage</a>.');
define('L_PRESETEDITOR_MSG_PRESET_DELETE','Weet u zeker dat u deze voorkeursinstellingen wilt verwijderen?');
define('L_PRESETEDITOR_MSG_PRESET_DELETED','Voorkeursinstellingen verwijderd');
define('L_PRESETEDITOR_MSG_PRESET_SAVED','Voorkeursinstellingen opgeslagen');

// anonymous_redirect.php
define('L_ANONYMOUS_REDIRECT','U wordt anoniem doorgestuurd naar:');

// menu-texts
define('L_MENU_WEBSITE','Website bezoeken');
define('L_MENU_ABOUT','Over CrazyStat');
define('L_MENU_STATISTIC','Open Statistieken');

// modules
define('L_MODULES_HIT_P','Klikken');
define('L_MODULES_HIT_S','Klik');
define('L_MODULES_WEEKDAY_P','Dagen van de week');
define('L_MODULES_WEEKDAY_S','Dag van de week');
define('L_MODULES_MONTH_P','Maanden');
define('L_MODULES_MONTH_S','Maand');
define('L_MODULES_DAY_P','Dagen');
define('L_MODULES_DAY_S','Dag');
define('L_MODULES_HOUR_P','Uren');
define('L_MODULES_HOUR_S','Uur');
define('L_MODULES_BROWSER_P','Browsers');
define('L_MODULES_BROWSER_S','Browser');
define('L_MODULES_FILE_P','Bestanden');
define('L_MODULES_FILE_S','Bestand');
define('L_MODULES_RESOLUTION_P','Resoluties');
define('L_MODULES_RESOLUTION_S','Resolutie');
define('L_MODULES_COLORDEPTH_P','Kleurdieptes');
define('L_MODULES_COLORDEPTH_S','Kleurdiepte');
define('L_MODULES_SYSTEM_P','Systeemen');
define('L_MODULES_SYSTEM_S','Systeem');
define('L_MODULES_REFERER_P','Verwijzers');
define('L_MODULES_REFERER_S','Verwijzer');
define('L_MODULES_KEYWORD_P','Trefwoorden');
define('L_MODULES_KEYWORD_S','Trefwoord');

// general error messages
define('L_MSG_ERR_INCLUDE_ONLY','Dit bestand kan niet rechtstreeks worden geopend.');
define('L_MSG_ERR_NO_MODULE','Geen module ingegeven of module bestaat niet.');
define('L_MSG_ERR','Foutmelding');
define('L_MSG_ERR_CONTINUE','Doorgaan');

// general texts
define('L_LOGOUT','Uitloggen');
define('L_CLOSE','Sluiten');
define('L_OK','OK');
define('L_NUMBER','Nee.');
define('L_TIME','Tijd');
define('L_DATE','Datum');
define('L_IP','IP');
define('L_USERAGENT','User Agent');
define('L_BIT','Bit');
define('L_DATE_FORMAT','d/m/y');
define('L_TIME_FORMAT','H:i:s');
define('L_GO','Gaan');
define('L_PLEASE_WAIT','Een ogenblik geduld alstublieft ...');
define('L_HITS','Klikken');
define('L_VISITS','Aantal bezoeken');
define('L_PAGEIMPRESSIONS','Paginaweergaven');
define('L_BACK','Terug');
define('L_CANCEL','Annuleren');
define('L_DELETE','Verwijderen');
define('L_REFRESH','Vernieuwen');
define('L_AND','en');
define('L_LANGUAGE','Taal');
define('L_NAME','Naam');



?>
