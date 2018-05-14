<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;

$redisEngine = env('REDIS_ENGINE', 'Redis');
$redisServer = env('REDIS_SERVER', 'localhost');

$prefix = 'apigateway_';

Cache::config('methods', [
    'engine' => $redisEngine,
    'server' => $redisServer,
    'duration' => '+4 week',
    'groups' => ['methods'],
    'prefix' => $prefix
]);

Cache::config('api-keys', [
    'engine' => $redisEngine,
    'server' => $redisServer,
    'duration' => '+1 week',
    'groups' => ['api-keys'],
    'prefix' => $prefix
]);