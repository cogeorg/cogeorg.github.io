<?php
$config_preset['17_this_year']=array(
'name'=>L_SHOWSTAT_PRESETS_THIS_YEAR,
'modules'=>array('CALENDAR'=>array(
    'time_span'=>true,
    'time_rel'=>true,
    'time_rel_start'=>'1.1.%Y',
    'time_rel_end'=>'1.1.%Y +1year -1second',
    'time_rel_startid'=>'',
    'time_rel_name'=>L_SHOWSTAT_PRESETS_THIS_YEAR
)),
'cache'=>false,
'cacheable'=>false);
?>