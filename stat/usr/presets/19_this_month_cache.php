<?php
// This preset is not visible in GUI because it has no name.
// Its purpose is to make caching of "This month" possible.
// "This month" is not cacheabale because it does not define
// ip-settings. This preset is cacheable because it does define
// ip-settings like the default-preset and the time-settings like
// "this month". With the help of this preset, "this month" is cached
// if the ip-settings are those of the default-preset (all turned on). 

$config_preset['19_this_month_cache']=array(
'modules'=>array('CALENDAR'=>array(
    'time_span'=>true,
    'time_rel'=>true,
    'time_rel_start'=>'1.%m.%Y',
    'time_rel_end'=>'1.%m.%Y +1month -1second',
    'time_rel_startid'=>'',
    'time_rel_name'=>L_SHOWSTAT_PRESETS_THIS_MONTH,
    'ip'=>true
)),
'cache'=>true
);
?>