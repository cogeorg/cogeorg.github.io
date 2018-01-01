<?php $config_preset['02_old_default']=array (
  'modules' => 
  array (
    'weekday' => 
    array (
      'ip' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'month' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/1/1',
      'time_rel_end' => '%Y/1/1 +1year -1second',
      'time_rel_name' => '%Y',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'day' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/1',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => '%Y/%m',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'hour' => 
    array (
      'ip' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'browser' => 
    array (
      'all' => false,
      'ip' => true,
      'piechart' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'file' => 
    array (
      'all' => false,
      'ip' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'resolution' => 
    array (
      'all' => false,
      'ip' => true,
      'piechart' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'colordepth' => 
    array (
      'all' => false,
      'ip' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'system' => 
    array (
      'all' => false,
      'ip' => true,
      'piechart' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'referer' => 
    array (
      'all' => false,
      'ip' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'keyword' => 
    array (
      'all' => false,
      'ip' => true,
      'time_span' => false,
      'time_rel' => false,
    ),
    'GLOBAL' => 
    array (
      'tree' => $config_stat_tree,
      'scroll' => $config_stat_scroll,
    ),
  ),
  'name' => L_SHOWSTAT_PRESETS_DEFAULT_OLD,
  'cache' => true,
); ?>