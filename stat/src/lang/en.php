<?php
// password_protect.php
define('L_PASSWORD_MES_ERR_NEW_INVALID','New password empty or not identical with repetition.');
define('L_PASSWORD_MES_ERR_NOT_CHANGED','Password was not changed!');
define('L_PASSWORD_MES_ERR_RETRY','Retry');
define('L_PASSWORD_MES_ERR_WRITING_FAILED','Password-file could not be opened for writing. Please check rights (CHMOD or write lock) of the file.');
define('L_PASSWORD_MES_OK_CHANGED','Password was successfully changed!');
define('L_PASSWORD_MES_ERR_NOT_LOGGED_IN','Session expired or not logged in.');
define('L_PASSWORD_MES_ERR_RELOGIN','Relogin');

define('L_PASSWORD_PLEASE_LOGIN','Please login');
define('L_PASSWORD_USERNAME','Username');
define('L_PASSWORD_PASSWORD','Password');
define('L_PASSWORD_DO_NOT_COUNT','Do not count hits from this computer');
define('L_PASSWORD_PLEASE_WAIT','Please wait...');
define('L_PASSWORD_MES_ERR_WRONG_DATA','Username or password incorrect. Access denied.');
define('L_PASSWORD_MES_OK_THANK_YOU','Thank you for using CrazyStat!');
define('L_PASSWORD_MES_SUPPORT_CRAZYSTAT','<a href="http://en.christosoft.de/Support">Please support CrazyStat!</a>');
define('L_PASSWORD_NO_JAVASCRIPT','Attention! The password has to be transferred unencrypted because your browser does not support JavaScript!');
define('L_PASSWORD_CHANGE_PASSWORD','Change password');
define('L_PASSWORD_OLD_PASSWORD','Old password');
define('L_PASSWORD_NEW_PASSWORD','New password');
define('L_PASSWORD_REPEAT_PASSWORD','Repeat password');
define('L_PASSWORD_CHANGE_AND_LOGIN','Change and login');
define('L_PASSWORD_MSG_ERR_NOMD5','Attention! The new password has to be transferred unencrypted because $config_stat_password_md5 is set false.<br />It is recommended to set this true to save the password encrypted (see FAQ).');
define('L_PASSWORD_MSG_ERR_NO_MD5JS','Attention! The password has to be transferred unencrypted because the file src/extensions/md5.js is missing. It is not recommended to delete this extension. You can find the missing file in the <a href="http://en.christosoft.de/_download/crazystat_current_version" target="_blank">CrazyStat download-file</a>.');

// index.php (some used by about.php as well)
define('L_INDEX_WELCOME','Welcome!');
define('L_INDEX_THIS_IS_CRAZYSTAT','This is CrazyStat, a comfortable, comprehensive and free statistic-script with optional counter.');
define('L_INDEX_INFORMATION','Information and updates can be found at:');
define('L_INDEX_INSTALLED_VERSION','Installed version:');
define('L_INDEX_CURRENT_VERSION','Current version:');
define('L_INDEX_NEWS','News at');

// about.php
define('L_ABOUT_PLEASE_SEE','Please see');
define('L_ABOUT_README','Readme');
define('L_ABOUT_FAQ','FAQ');
define('L_ABOUT_FOR_HELP','for help.');

// password_protect.php and index.php
define('L_LOGIN_MENU_HOME','Home');
define('L_LOGIN_MENU_LOGIN','Login');
define('L_LOGIN_MENU_CHANGE_PASSWORD','Change password');

// calendar.php
define('L_CALENDAR_TITLE','Define period');
define('L_CALENDAR_MSG_ERR_YEAR_INVALID','Invalid year, please only use digits.');
define('L_CALENDAR_MSG_ERR_MONTH_ONLY','Error: Please choose month <i>and</i> year.');
define('L_CALENDAR_MSG_ERR_NO_JS','As you are using a browser that does not support JavaScript or you disabled JavaScript, you must click to continue:');
define('L_CALENDAR_LIMIT_YEAR','Limit by year');
define('L_CALENDAR_LIMIT_MONTH','Limit by month');
define('L_CALENDAR_LIMIT_PERIOD','Limit by time period');
define('L_CALENDAR_MONTH_ABR','Jan Feb Mar Apr May June July Aug Sept Oct Nov Dec');
define('L_CALENDAR_MONTH_NAMES','January February March April May June July August September October November December');
define('L_CALENDAR_WEEKDAYS_ABR','S M T W T F S');
define('L_CALENDAR_WEEKDAYS','Sunday Monday Tuesday Wednesday Thursday Friday Saturday');
define('L_CALENDAR_TODAY','Today');
define('L_CALENDAR_WEEK_START_DAY',0);
define('L_CALENDAR_START','Start');
define('L_CALENDAR_END','End');
define('L_CALENDAR_RELATIVE','Relative');
define('L_CALENDAR_ABSOLUTE','Absolute');
define('L_CALENDAR_RELATIVE_PRESET','Preset');
define('L_CALENDAR_RELATIVE_CUSTOM','Custom');
define('L_CALENDAR_RELATIVE_THIS_WEEK','This week');
define('L_CALENDAR_RELATIVE_THIS_MONTH','This month');
define('L_CALENDAR_RELATIVE_THIS_YEAR','This year');
define('L_CALENDAR_RELATIVE_CHECK','Check');
define('L_CALENDAR_RELATIVE_HELP','Please read the helpfile on how this works.');

// create_counter_image.php
define('L_COUNTER_FILE_NOT_FOUND','counter style not found');
define('L_COUNTER_GIF_NOT_SUPPORTED','gif-files not supported');
define('L_COUNTER_TYPE_NOT_SUPPORTED','file-type not supported');

// nojs.php
define('L_NOJS_TITLE','No JavaScript');
define('L_NOJS_TEXT',
' <p>Unfortunately your browser does not support JavaScript or you disabled it. It is recommended to use a JavaScript-compliant browser, e.g. <a href="http://www.mozilla.com/">Firefox</a>, or activate JavaScript in your browser if you disabled it.</p>
  <p>In some cases this message appears if there was an error in a JavaScript. If your browser supports JavaScript and it is enabled, please go back and retry it.</p>
  <p>
  This message can also appear, if a JavaScript is executed whereas the site is not fully loaded.<br />
  In this case, please go back, wait until the site is fully loaded and click again on the icon you just clicked on.
  </p>');
  
// stat.php
define('L_STAT_MSG_ERR_COUNTER_FILE','corrupt or RC?');
define('L_STAT_MSG_ERR_READ_ERROR','Read error (Rights?)');
define('L_STAT_MSG_ERR_WRITE_ERROR','Write error (Rights?)');

// analyze.php
define('L_ANALYZE_MSG_OK_CACHE_EXISTED','There was a cache file for the logs in the newly created folder. This cache file was deleted.');
define('L_ANALYZE_MSG_ERR_LOGFOLDER_INEXISTENT','The folder in which the logfiles should be placed does not exist');
define('L_ANALYZE_MSG_ERR_CREATE_FOLDER','Create folder');
define('L_ANALYZE_MSG_ERR_FILE_CREATION_FAILED','The file could not be created');
define('L_ANALYZE_MSG_ERR_FILE_NOT_FOUND','The Log-file could not be found. Please try cleaning the cache.');
define('L_ANAYLZE_MSG_ERR_CHECK_RIGHTS','Please check "usr/config.php" and the rights of the folder in which the logfiles should be placed.');
define('L_ANAYLZE_MSG_ERR_CACHE_NOT_DELETED','A cache-file could not be deleted. Please check rights.');
define('L_ANALYZE_UNKNOWN_FILE','Unknown');
define('L_ANALYZE_UNKNOWN_SYSTEM','Others');
define('L_ANALYZE_UNKNOWN_BROWSER','Others');
define('L_ANALYZE_UNKNOWN_RESOLUTION','no JavaScript');
define('L_ANALYZE_UNSAVED','Not saved');
define('L_ANALYZE_MSG_ERR_COUNTERFILE_INEXISTENT','Counter-file could not be read. Trying to create new one.');
define('L_ANALYZE_MSG_ERR_COUNTERFILE_CREATION_FAILED','Creation failed (rights?). No data has been lost, but CrazyStat is working inefficiently. See FAQ.');
define('L_ANALYZE_MSG_OK_COUNTERILE_CREATED','Counterfile created successfully. This is no problem, no data has been lost.');
define('L_ANALYZE_MSG_ERR_CACHE_SAVE_FAILED','could not be opened for writing. Please check rights (CHMOD - see <a href="../doc/README_en.html" target="_blank">README_en.html</a>).');
define('L_ANALYZE_MSG_ERR_INCOMPLETE','The statistic could not be fully generated.');
define('L_ANALYZE_MSG_ERR_TIMEOUT','Probably the maximum execution time was exceeded ("Fatal error: Maximum execution time of ... seconds exceeded"). This is a limitation of your server. In this case, CrazyStat can continue generating the statistic. Maybe you have to click \'Continue\' more than once.');
define('L_ANALYZE_MSG_ERR_MEMORY_LIMIT','Probably the memory-limit was exceeded ("Allowed memory size of ... exhausted"). In this case, try to increase <a href="../doc/config_settings_en.html#config_stat_memory_limit">$config_stat_memory_limit</a>.');
define('L_ANALYZE_MSG_ERR_UNKNOWN_ERROR','Most likely an error occurred (any error messages above?). Possibly (unlikely) the maximum execution time or the memory limit was exceeded. CrazyStat can try to continue generating the statistic.');
define('L_ANALYZE_MSG_ERR_CURRENT_POSITION','Current position');
define('L_ANALYZE_MSG_ERR_GUEST_CLEAR_CACHE','You are not allowed to clear the cache. See <a href="../doc/config_settings_en.html#config_stat_guest_cache_delete" target="_blank">$config_stat_guest_cache_delete</a> and <a href="../doc/config_settings_en.html#config_stat_user_cache_delete" target="_blank">$config_stat_user_cache_delete</a>.');
define('L_ANALYZE_MSG_ERR_CACHE_BROKEN','Cache-file seems to be broken. Please do the following to fix this issue:');

// show_log.php
define('L_SHOWLOG_TITLE','Log');
define('L_SHOWLOG_ALLLOGS','All logfiles');
define('L_SHOWLOG_MSG_ERR_INVALID_ID','There is no logfile with this id.');
define('L_SHOWLOG_MSG_ERR_LOGFILE_NOTFOUND','The logfile to be showed does not exist. Please check whether the following file exists:');
define('L_SHOWLOG_END_OF_LOGFILE','End of logfile');
define('L_SHOWLOG_NEXT_LOGFILE','Next logfile');
define('L_SHOWLOG_PREV_LOGFILE','Previous logfile');
define('L_SHOWLOG_PREV_PAGE','Previous page');
define('L_SHOWLOG_NEXT_PAGE','Next page');
define('L_SHOWLOG_PAGE','Page');
define('L_SHOWLOG_FORWARD','Forward');
define('L_SHOWLOG_BACKWARD','Backward');
define('L_SHOWLOG_TEXT','Text');
define('L_SHOWLOG_TABLE','Table');
define('L_SHOWLOG_FILTERED','filtered');
define('L_SHOWLOG_ROWS_FOUND','row(s) found');

// logs.php
define('L_LOGS_SEARCH_CONTAINS','contains');
define('L_LOGS_SEARCH_CONTAINS_NOT','contains not');
define('L_LOGS_SEARCH_UNEQUAL','unequal');
define('L_LOGS_VALUE','Value');
define('L_LOGS_TITLE','Log files');
define('L_LOGS_BACKUP','Backup');
define('L_LOGS_VIEW','View');
define('L_LOGS_FILTER_TITLE','Search inside logs (filter)');
define('L_LOGS_ADD_CONDITION','Add condition');
define('L_LOGS_SEARCH_SUBMIT','Search');
define('L_LOGS_SEARCH_WAIT','Searching in logs... Please wait.');
define('L_LOGS_MSG_ERR_NOFILE','No file was selected.');
define('L_LOGS_MSG_CONFIM_DELETE','Do you really want to permanently delete the following files?');
define('L_LOGS_SEARCH','Search');
define('L_LOGS_SELECT_ALL','Select all');
define('L_LOGS_SELECT_NONE','Deselect all');
define('L_LOGS_SELECTED','selected');
define('L_LOGS_MSG_ERR_GUEST_DOWNLOAD','You are not allowed to download logfiles. See <a href="../doc/config_settings_en.html#config_stat_guest_log_download" target="_blank">$config_stat_guest_log_download</a> and <a href="../doc/config_settings_en.html#config_stat_user_log_download" target="_blank">$config_stat_user_log_download</a>.');
define('L_LOGS_MSG_ERR_GUEST_DELETE','You are not allowed to delete logfiles. See <a href="../doc/config_settings_en.html#config_stat_guest_log_delete" target="_blank">$config_stat_guest_log_delete</a> and <a href="../doc/config_settings_en.html#config_stat_user_log_delete" target="_blank">$config_stat_user_log_delete</a>.');

// show_stat.php
define('L_SHOWSTAT_PRESETS','Presets');
define('L_SHOWSTAT_PRESETS_DEFAULT','Default');
define('L_SHOWSTAT_PRESETS_DEFAULT_OLD','Old Default');
define('L_SHOWSTAT_PRESETS_IP1','Block by IP');
define('L_SHOWSTAT_PRESETS_IP0','Do not block by IP');
define('L_SHOWSTAT_PRESETS_PIE_CHARTS','Pie charts');
define('L_SHOWSTAT_PRESETS_BAR_CHARTS','Bar charts');
define('L_SHOWSTAT_PRESETS_THIS_YEAR','This year');
define('L_SHOWSTAT_PRESETS_THIS_MONTH','This month');
define('L_SHOWSTAT_PRESETS_ALL','Show all (all)');
define('L_SHOWSTAT_PRESETS_LIMIT','Show only first (limit)');
define('L_SHOWSTAT_PRESETS_SCROLL1','Module-scrollbars on');
define('L_SHOWSTAT_PRESETS_SCROLL0','Module-scrollbars off');
define('L_SHOWSTAT_PRESETS_TOTAL_TIME','Total time');
define('L_SHOWSTAT_PRESETS_CURRENT_PERIOD','Current Period');
define('L_SHOWSTAT_PRESETS_MANAGE','Manage Presets');
define('L_SHOWSTAT_CLEAR_CACHE','Clear cache');
define('L_SHOWSTAT_REFRESH_ALL','Refresh all');
define('L_SHOWSTAT_LOGS','Logs');
define('L_SHOWSTAT_MSG_OK_WAIT','The operation you requested takes a moment. Probably the statistic has to be regenerated which may take some time.');

// preset-specific
define('L_PRESET_DEFAULT_YEAR','last 12 months');
define('L_PRESET_DEFAULT_MONTH','a month\'s time');
define('L_PRESET_DEFAULT_WEEK','last 7 days');
define('L_PRESET_DEFAULT_DAY','last 24 hours');

// module_out.php
define('L_MODULEOUT_HITS_PI','Total Page Views');
define('L_MODULEOUT_HITS_VISITS','Total Visits');
define('L_MODULEOUT_HITS_THIS_MONTH','Visits this month');
define('L_MODULEOUT_HITS_LAST_MONTH','Visits last month');
define('L_MODULEOUT_HITS_USER_ONLINE','User online');
define('L_MODULEOUT_HITS_MAX_DAY','Maximum Visits day');
define('L_MODULEOUT_HITS_AV_PER_DAY','Average Visits/day');
define('L_MODULEOUT_HITS_HITS_PER_USER','Average Page Views/Visitor');
define('L_MODULEOUT_IP0','Page Views (Not blocked by IP)');
define('L_MODULEOUT_IP1','Visits (Blocked by IP)');
define('L_MODULEOUT_NO_DATA','no data');
define('L_MODULEOUT_TOTAL_TIME','total time');
define('L_MODULEOUT_PIE_CHART','Pie chart');
define('L_MODULEOUT_BAR_CHART','Bar chart');
define('L_MODULEOUT_SORT_BY','Click to sort by');
define('L_MODULEOUT_SORT_BY_NUM','Click to sort by number');
define('L_MODULEOUT_SORT_BY_PER','Click to sort by percentage');
define('L_MODULEOUT_SORT_BY_RATIO','Click to sort by ratio');
define('L_MODULEOUT_NUM','Number');
define('L_MODULEOUT_NUM_ABR','Num.');
define('L_MODULEOUT_PER','Perc.');
define('L_MODULEOUT_TOTAL','Total');
define('L_MODULEOUT_RATIO','Ratio');
define('L_MODULEOUT_DOMAINS','Domains');
define('L_MODULEOUT_PAGES','Pages');
define('L_MODULEOUT_COLORS','colors');
define('L_MODULEOUT_CONSOLE_PERIOD','Period');
define('L_MODULEOUT_CONSOLE_PERIOD_DEFINE','Define period');
define('L_MODULEOUT_CLICK_IP1','Click for visitors (blocked by IP).');
define('L_MODULEOUT_CLICK_IP0','Click for page-views (not blocked by IP).');
define('L_MODULEOUT_CONSOLE_ALL','Show all');
define('L_MODULEOUT_CONSOLE_ALL_ABR','All');
define('L_MODULEOUT_CONSOLE_SHOW_ONLY','Show only');
define('L_MODULEOUT_CONSOLE_TREE_ABR','Enable tree view');
define('L_MODULEOUT_CONSOLE_TREE','Enable tree view and sort referrers by host');
define('L_MODULEOUT_CONSOLE_TREE_OFF','Disable tree view, list all referrers');
define('L_MODULEOUT_CONSOLE_TREE_OFF_ABR','Disable tree view');
define('L_MODULEOUT_CONSOLE_TREE_OTHER','Change tree extension');
define('L_MODULEOUT_CONSOLE_TREE_COLLAPSE','Collapse tree');
define('L_MODULEOUT_CONSOLE_TREE_EXPAND','Expand tree');
define('L_MODULEOUT_PRETTYINT_SUFFIX','m bn trillion quadrillion quintillion sextillion');

// preset_editor.php
define('L_PRESETEDITOR_MANAGE_PRESETS','Manage presets');
define('L_PRESETEDITOR_ID','ID');
define('L_PRESETEDITOR_CACHE_SIZE','Cache size');
define('L_PRESETEDITOR_SAVE_PRESET','Save preset');
define('L_PRESETEDITOR_SAVE_PRESET_TEXT','This will save the current settings (all of them) as a preset for future use. All settings are automatically detected.');
define('L_PRESETEDITOR_SAVE_PRESET_MSG_ABS','WARNING: You current settings contain absolute time-spans for the following module(s)');
define('L_PRESETEDITOR_SAVE_PRESET_MSG_ABS2','Absolute time-spans do not make much sense to save as a preset!');
define('L_PRESETEDITOR_SAVE_PRESET_DUPLICATE','This preset is exactly the same as:');
define('L_PRESETEDITOR_SAVE_PRESET_DUPLICATE_CANNOT_BE_SAVED','You can only save presets that are different from existing ones.');
define('L_PRESETEDITOR_CACHE','Cache this preset');
define('L_PRESETEDITOR_CACHE_NOT','Do not cache this preset');
define('L_PRESETEDITOR_CACHE_UNCACHEABLE','This preset cannot be cached');
define('L_PRESETEDITOR_MSG_ERR_GUEST','You are not allowed to manage presets. See <a href="../doc/config_settings_en.html#config_stat_guest_preset_manage" target="_blank">$config_stat_guest_preset_manage</a> and <a href="../doc/config_settings_en.html#config_stat_user_preset_manage" target="_blank">$config_stat_user_preset_manage</a>.');
define('L_PRESETEDITOR_MSG_PRESET_DELETE','Do you really want to delete this preset');
define('L_PRESETEDITOR_MSG_PRESET_DELETED','Preset deleted');
define('L_PRESETEDITOR_MSG_PRESET_SAVED','Saved preset');

// anonymous_redirect.php
define('L_ANONYMOUS_REDIRECT','You are redirected anonymously to:');

// menu-texts
define('L_MENU_WEBSITE','Visit Website');
define('L_MENU_ABOUT','About CrazyStat');
define('L_MENU_STATISTIC','Open Statistic');

// modules
define('L_MODULES_HIT_P','Hits');
define('L_MODULES_HIT_S','Hit');
define('L_MODULES_WEEKDAY_P','Weekdays');
define('L_MODULES_WEEKDAY_S','Weekday');
define('L_MODULES_MONTH_P','Months');
define('L_MODULES_MONTH_S','Month');
define('L_MODULES_DAY_P','Days');
define('L_MODULES_DAY_S','Day');
define('L_MODULES_HOUR_P','Hours');
define('L_MODULES_HOUR_S','Hour');
define('L_MODULES_BROWSER_P','Browsers');
define('L_MODULES_BROWSER_S','Browser');
define('L_MODULES_FILE_P','Files');
define('L_MODULES_FILE_S','File');
define('L_MODULES_RESOLUTION_P','Resolutions');
define('L_MODULES_RESOLUTION_S','Resolution');
define('L_MODULES_COLORDEPTH_P','Color Depths');
define('L_MODULES_COLORDEPTH_S','Color Depth');
define('L_MODULES_SYSTEM_P','Systems');
define('L_MODULES_SYSTEM_S','System');
define('L_MODULES_REFERER_P','Referrer');
define('L_MODULES_REFERER_S','Referrer');
define('L_MODULES_KEYWORD_P','Keywords');
define('L_MODULES_KEYWORD_S','Keyword');

// general error messages
define('L_MSG_ERR_INCLUDE_ONLY','This file cannot be opened directly.');
define('L_MSG_ERR_NO_MODULE','No module specified or no such module.');
define('L_MSG_ERR','Error');
define('L_MSG_ERR_CONTINUE','Continue');

// general texts
define('L_LOGOUT','Logout');
define('L_CLOSE','Close');
define('L_OK','OK');
define('L_NUMBER','No.');
define('L_TIME','Time');
define('L_DATE','Date');
define('L_IP','IP');
define('L_USERAGENT','User Agent');
define('L_BIT','Bit');
define('L_DATE_FORMAT','Y/m/d');
define('L_TIME_FORMAT','H:i:s');
define('L_GO','Go');
define('L_PLEASE_WAIT','Please wait ...');
define('L_HITS','Hits');
define('L_VISITS','Visits');
define('L_PAGEIMPRESSIONS','Page Views');
define('L_BACK','Back');
define('L_CANCEL','Cancel');
define('L_DELETE','Delete');
define('L_REFRESH','Refresh');
define('L_AND','and');
define('L_LANGUAGE','Language');
define('L_NAME','Name');



?>
