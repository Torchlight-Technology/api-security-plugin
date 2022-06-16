<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;

$redisEngine = env('REDIS_ENGINE', 'Redis');
$redisServer = env('REDIS_SERVER', 'localhost');

$prefix = 'apigateway_';

Cache::drop('methods');
Cache::drop('api-keys');

Cache::setConfig('methods', [
    'engine' => $redisEngine,
    'server' => $redisServer,
    'duration' => '+4 week',
    'groups' => ['methods'],
    'prefix' => $prefix
]);

Cache::setConfig('api-keys', [
    'engine' => $redisEngine,
    'server' => $redisServer,
    'duration' => '+1 week',
    'groups' => ['api-keys'],
    'prefix' => $prefix
]);
