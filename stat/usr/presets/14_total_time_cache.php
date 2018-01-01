<?php
// This preset is not visible in GUI because it has no name.
// Its purpose is to make caching of "total time" possible.
// "total time" is not cacheabale because it does not define
// ip-settings. This preset is cacheable because it does define
// ip-settings like the default-preset and the time-settings like
// "total time". With the help of this preset, "total time" is cached
// if the ip-settings are those of the default-preset (all turned on). 

$config_preset['14_total_time_cache']=array(
'modules'=>array('CALENDAR'=>array('time_span'=>false,'time_rel'=>false,'ip'=>true)),
'cache'=>true);
?>