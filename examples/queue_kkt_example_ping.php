<?php
/**
 * Пример создания объекта Ping
 * Описывает метод /ping сервиса онлайн касс
 *
 * Описывает пример пинга сервиса
 */
require_once __DIR__ . '/init.php';

use \Rarus\Online\Kkt\Service\Transport as ServiceTransport;

$serviceTransport = new ServiceTransport($apiClient, $log);
$serviceTransportDto = $serviceTransport->ping();


$log->info('rarus.online.kkt.service.getPing', [
    'pingDto'=> $serviceTransportDto->toArray()
]);

print('object Ping '.PHP_EOL);
print(sprintf(' -message: %s'.PHP_EOL, $serviceTransportDto->getMessage()));
