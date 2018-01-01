<?php $config_preset['01_default']=array (
  'modules' => 
  array (
    'weekday' => 
    array (
      'ip' => true,
      'time_rel_start' => 'tomorrow -1week',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_WEEK,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '%w+1',
    ),
    'month' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/1 -1year +1month',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => L_PRESET_DEFAULT_YEAR,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '%m+1',
    ),
    'day' => 
    array (
      'ip' => true,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_MONTH,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '%d+1',
    ),
    'hour' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/%d %H:00:00 -1 day +1hour',
      'time_rel_end' => '%Y/%m/%d %H:00:00 +1hour',
      'time_rel_name' => L_PRESET_DEFAULT_DAY,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '%H+2',
    ),
    'browser' => 
    array (
      'all' => false,
      'ip' => true,
      'piechart' => true,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_MONTH,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'file' => 
    array (
      'all' => false,
      'ip' => true,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_MONTH,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'resolution' => 
    array (
      'all' => false,
      'ip' => true,
      'piechart' => true,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_MONTH,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'colordepth' => 
    array (
      'all' => false,
      'ip' => true,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_MONTH,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'system' => 
    array (
      'all' => false,
      'ip' => true,
      'piechart' => true,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_MONTH,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'referer' => 
    array (
      'all' => false,
      'ip' => true,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_MONTH,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'keyword' => 
    array (
      'all' => false,
      'ip' => true,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => L_PRESET_DEFAULT_MONTH,
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'GLOBAL' => 
    array (
      'tree' => $config_stat_tree,
      'scroll' => $config_stat_scroll,
    ),
  ),
  'name' => L_SHOWSTAT_PRESETS_DEFAULT,
  'cache' => true,
); ?>