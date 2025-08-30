<?php
/**
 * Пример создания объекта Version
 * Описывает метод /version
 *
 * Описывает пример результата получения списка версий протокола
 */
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\Online\Kkt\ApiClient;
use Rarus\Online\Kkt\Service\Transport as ServiceTransport;

global $log;
global $apiClient;

$serviceTransport = new ServiceTransport($apiClient, $log);
$versionCollection = $serviceTransport->getVersions('versions', 'get');

foreach ($versionCollection as $version) {
    print('object Version'.PHP_EOL);
    print(sprintf(' -version: %s'.PHP_EOL, $version->getVersion()));
    print(sprintf(' -base_url: %s'.PHP_EOL, $version->getBaseUrl()));
    print(sprintf(' -stable: %s'.PHP_EOL, $version->isIsStable()));

    $log->info('rarus.online.kkt.service.getVersion', [
        'versionDto'=> $version->toArray()
    ]);
}
