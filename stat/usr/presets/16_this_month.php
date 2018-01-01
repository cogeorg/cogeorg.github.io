<?php
$config_preset['16_this_month']=array(
'name'=>L_SHOWSTAT_PRESETS_THIS_MONTH,
'modules'=>array('CALENDAR'=>array(
    'time_span'=>true,
    'time_rel'=>true,
    'time_rel_start'=>'1.%m.%Y',
    'time_rel_end'=>'1.%m.%Y +1month -1second',
    'time_rel_startid'=>'',
    'time_rel_name'=>L_SHOWSTAT_PRESETS_THIS_MONTH
)),
'cache'=>false,
'cacheable'=>false);
?>