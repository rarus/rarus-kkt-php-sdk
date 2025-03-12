<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\{Client, HandlerStack, Middleware, MessageFormatter};
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\SocketHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\WhatFailureGroupHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\UidProcessor;
use Rarus\Online\Kkt\ApiClient;

// инициализируем логи
$log = new Logger('rarus-kkt-php-sdk');
$log->pushHandler(new StreamHandler('rarus-kkt-php-sdk.log', Logger::DEBUG));

$guzzleHandlerStack = HandlerStack::create();
$guzzleHandlerStack->push(
    Middleware::log(
        $log,
        new MessageFormatter(MessageFormatter::SHORT)
    )
);
// http-клиент
$log->info('=================================================================');
$log->info('rarus.online.kkt.apiClient.start');

// параметры подключения ожидаем как аргументы командной строки
$argv = getopt('', ['url::', 'api_key::']);

$example = 'php -f 01_menu.php -- --url=https://127.0.0.1 --api_key=123456';

if ($argv['url'] === null) {
    $errMsg = sprintf('ошибка: не найден url для подключения, пример вызова скрипта: %s', $example);
    $log->error($errMsg, [$argv]);
    print($errMsg . PHP_EOL);
    exit();
}

if ($argv['api_key'] === null) {
    $errMsg = sprintf('ошибка: не найден пароль для подключения, пример вызова скрипта: %s', $example);
    $log->error($errMsg, [$argv]);
    print($errMsg . PHP_EOL);
    exit();
}


// http-клиент
$httpClient = new Client();
$apiClient = new ApiClient($argv['url'], (string)$argv['api_key'], $httpClient, $log);

$apiClient->setGuzzleHandlerStack($guzzleHandlerStack);
