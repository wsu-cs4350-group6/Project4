<?php

use Slim\Slim;

$autoLoader = realpath(
    __DIR__
    . DIRECTORY_SEPARATOR .'..'
    . DIRECTORY_SEPARATOR .'..'
    . DIRECTORY_SEPARATOR . 'vendor'
    . DIRECTORY_SEPARATOR . 'autoload.php'
);

require $autoLoader;

require 'config.php';

$app = new Slim(
    $config['app']['slim-config']
);

$env = $app->environment;
$env['config'] = $config;

foreach($config['app']['endpoints'] as $endpoint)
{
    require $endpoint;
}

foreach($config['app']['mysql'] as $key => $value)
{
    $app->$key = $value;
}
$app->sqliteFile = $config['app']['sqlite'];

$app->sqliteFile = $config['app']['sqlite'];

$app->run();