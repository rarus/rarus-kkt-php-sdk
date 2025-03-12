<?php
/**
 * Пример создания объекта ZReports
 * Описывает метод reports/z
 *
 * Описывает пример результата получения списка z-отчетов,
 * которые были сформированы фермой ККТ с указанным идентификатором api_key
 */
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\Online\Kkt\{
    Queue\Transport as QueueTransport,
    Service\Transport as ServiceTransport
};

global $log;
global $apiClient;

$serviceTransport = new ServiceTransport($apiClient, $log);
$serviceTransportDto = $serviceTransport->getVersions('versions', 'get');

$versions = [];

foreach ($serviceTransportDto as $item) {
    $versions[] = $item;
}

// выбираем версию v1
$versionDto = $versions[1];

if (count($versions) === 1) {
    $versionDto = $versions[0];
}

$queueTransport = new QueueTransport($apiClient, $versionDto, $log);
$zReportsDto = $queueTransport->getZReports(new DateTime('10.07.2017'), new DateTime('02.08.2017'));

foreach ($zReportsDto as $item) {
    print('object ZReports ' . PHP_EOL);
    print(sprintf(' -fiscal_doc_number: %s' . PHP_EOL, $item->getFiscalDocNum()));
    print(sprintf(' -fiscal_shift_num: %s' . PHP_EOL, $item->getFiscalShiftNum()));
    print(sprintf(' -timestamp_uts: %s' . PHP_EOL, $item->getTimeStampUts()->format($item->getTimeStampUts()::ATOM)));

    $log->info('rarus.online.kkt.service.getZReports', [
        'zReportsDto' => $item->toArray()
    ]);
}
