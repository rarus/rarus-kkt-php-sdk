<?php
/**
 * Пример создания объекта OperationStatus
 * Описывает метод /document/{operation_id}
 *
 * Описывает пример результата проверки состояния операции
 */
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\Online\Kkt\{
    Service\Transport as ServiceTransport,
    Queue\Transport as QueueTransport,
    Queue\DTO\OperationState
};

global $log;
global $apiClient;

try {
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

    $documentState = [
        // Может быть только уже существующий ID
        // Полученный из метода addDocument()
        'operation_id'  => '454EC39F-E1BD-453A-AD52-B086089D50C6',
        'timestamp_utc' => '1501163536',
        'status'        => 'wait',
        'message'       => 'Документ в очереди на обработку'
    ];

    $operationState = new OperationState(
        (string)$documentState['operation_id'],
        (string)$documentState['timestamp_utc'],
        (string)$documentState['status'],
        (string)$documentState['message']
    );

    $queueTransport = new QueueTransport($apiClient, $versionDto, $log);
    $operationStatusDto = $queueTransport->getDocumentOperationStatusByOperationId($operationState);


    $log->info('rarus.online.kkt.service.getDocumentById', [
        'operationStatusDto' => array_merge(
            $operationStatusDto->getFiscalisation()->toArray(),
            $operationStatusDto->getOperationState()->toArray()
        )
    ]);


    print('object OperationState' . PHP_EOL);

    print('-object OperationStatus' . PHP_EOL);
    print(sprintf(' -operation_id: %s' . PHP_EOL, $operationStatusDto->getOperationState()->getExternalOperationId()));
    print(sprintf(' -timestamp_utc: %s' . PHP_EOL, $operationStatusDto->getOperationState()->getTimestampUtc()));
    print(sprintf(' -status: %s' . PHP_EOL, $operationStatusDto->getOperationState()->getStatus()));
    print(sprintf(' -message: %s' . PHP_EOL, $operationStatusDto->getOperationState()->getMessage()));

    print('-object Fiscalisation' . PHP_EOL);
    print(sprintf(' -total: %s' . PHP_EOL, $operationStatusDto->getFiscalisation()->getTotal()->getAmount()));
    print(sprintf(' -fiscal_number: %s' . PHP_EOL, $operationStatusDto->getFiscalisation()->getFiscalNumber()));
    print(sprintf(
        ' -shift_fiscal_number: %s' . PHP_EOL,
        $operationStatusDto->getFiscalisation()->getShiftFiscalNumber()
    ));
    print(sprintf(' -receipt_date: %s' . PHP_EOL, $operationStatusDto->getFiscalisation()->getReceiptDate()));
    print(sprintf(' -fn_number: %s' . PHP_EOL, $operationStatusDto->getFiscalisation()->getFnNumber()));
    print(sprintf(
        ' -kkt_registration_number: %s' . PHP_EOL,
        $operationStatusDto->getFiscalisation()->getKktRegistrationNumber()
    ));
    print(sprintf(' -fiscal_attribute: %s' . PHP_EOL, $operationStatusDto->getFiscalisation()->getFiscalAttribute()));
    print(sprintf(' -fiscal_doc_number: %s' . PHP_EOL, $operationStatusDto->getFiscalisation()->getFiscalDocNumber()));
    print(sprintf(' -fns_site: %s' . PHP_EOL, $operationStatusDto->getFiscalisation()->getFnsSite()));

} catch (\Throwable $exception) {

    $log->error('rarus.online.kkt.service.getDocumentById ',
        ['message' => $exception->getMessage(), 'trace' => $exception->getTraceAsString()]);
}
