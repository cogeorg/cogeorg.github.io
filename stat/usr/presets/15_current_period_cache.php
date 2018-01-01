<?php
// This preset is not visible in GUI because it has no name.
// Its purpose is to make caching of "Current period" possible.
// "current period" is not cacheabale because it does not define
// ip-settings. This preset is cacheable because it does define
// ip-settings like the default-preset and the time-settings like
// "current period". With the help of this preset, "current period" is cached
// if the ip-settings are those of the default-preset (all turned on). 

$config_preset['15_current_period_cache']=array (
  'modules' => 
  array (
    'weekday' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y-W%W-1',
      'time_rel_end' => '%Y-W%W-1 +1week -1second',
      'time_rel_name' => '%Y-W%W',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
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
      'time_rel_start' => 'today',
      'time_rel_end' => 'tomorrow -1second',
      'time_rel_name' => '%Y/%m/%d',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'browser' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/1',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => '%Y/%m',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'file' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/1',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => '%Y/%m',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'resolution' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/1',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => '%Y/%m',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'colordepth' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/1',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => '%Y/%m',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'system' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/1',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => '%Y/%m',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'referer' => 
    array (
      'ip' => true,
      'time_rel_start' => '%Y/%m/1',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => '%Y/%m',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
    'keyword' => 
    array (
      'time_rel_start' => '%Y/%m/1',
      'time_rel_end' => '%Y/%m/1 +1month -1second',
      'time_rel_name' => '%Y/%m',
      'time_span' => true,
      'time_rel' => true,
      'time_rel_startid' => '',
    ),
  ),
  'cache' => true,
); ?>