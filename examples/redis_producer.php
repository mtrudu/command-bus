<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/tools/FooCommand.php';
require_once __DIR__.'/tools/Logger.php';

use Rezzza\CommandBus;

$i = isset($argv[1]) ? (int) $argv[1] : 10;

$redis = new \Redis();
$redis->connect('127.0.0.1');

$redisKeyGenerator = new CommandBus\Infra\Provider\Redis\RedisKeyGenerator();
$serializer        = new CommandBus\Infra\Serializer\NativeSerializer();
$bus               = new CommandBus\Infra\Provider\Redis\RedisBus($redis, $redisKeyGenerator, $serializer);

for ($j = 0; $j < $i; $j++) {
    $bus->handle(new FooCommand(uniqid()));
    echo ".";
}
