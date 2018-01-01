<?php
// This preset is not visible in GUI because it has no name.
// Its purpose is to make caching of "do not block by IP" possible.
// "do not block by IP" is not cacheabale because it does not define
// time-settings. This preset is cacheable because it does define
// time-settings like the default-preset and the ip-settings like
// "do not block by IP". With the help of this preset, "do not block by IP" is 
// cached if the time-settings are those of the default-preset. 

 $config_preset['13_default_ip0_cache']=array (
  'modules' => 
  array (
    'weekday' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1week',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'last 7 days',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '%w+1',
    ),
    'month' => 
    array (
      'ip' => false,
      'time_rel_start' => '%Y/%m/1 -1year +1month',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => 'last 12 Months',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '%m+1',
    ),
    'day' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'a month\'s time',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '%d+1',
    ),
    'hour' => 
    array (
      'ip' => false,
      'time_rel_start' => '%Y/%m/%d %H:00:00 -1 day +1hour',
      'time_rel_end' => '%Y/%m/%d %H:00:00 +1hour',
      'time_rel_name' => 'last 24 hours',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '%H+2',
    ),
    'browser' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'a month\'s time',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'file' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'a month\'s time',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'resolution' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'a month\'s time',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'colordepth' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'a month\'s time',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'system' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'a month\'s time',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'referer' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'a month\'s time',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'keyword' => 
    array (
      'ip' => false,
      'time_rel_start' => 'tomorrow -1 month',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => 'a month\'s time',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
  ),
  'cache' => true,
); ?>