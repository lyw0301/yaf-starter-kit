<?php
use Yaf\Application as YafApplication;
use Yaf\Response\Http;

define('ROOT_PATH', realpath(__DIR__.'/../'));
define('APP_PATH', realpath(__DIR__.'/../app'));
define('APP_START', microtime(true));

$app = new YafApplication(ROOT_PATH.'/config/framework.ini');

$response = $app->bootstrap()->run();

if ($response instanceof Http) {
    $response->response();
}
