<?php
/**
 * Пример создания объекта OperationState
 * Описывает метод document сервиса онлайн касс
 *
 * Описывает пример результата отправки документа на обработку
 */
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use \Rarus\Online\Kkt\{
    Queue\DTO\User,
    Queue\DTO\Product,
    Queue\DTO\Document,
    Queue\DTO\ProductCollection,
    Queue\Transport as QueueTransport,
    Service\Transport as ServiceTransport
};
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use \Rarus\Online\Kkt\Taxes\TaxesFabric;
use Money\Formatter\DecimalMoneyFormatter;
use \Rarus\Online\Kkt\Exception\InvalidTaxCodeException;

$documentArray = [
    // На каждый запуск примера должен быть новый id
    // id может не быть. Параметр не обязательный.
    // Если id нет, то просто не указываем его.
    //'id'              => '496DEF23-EBB3-4A24-8F23-AE709BE81308',
    'doc_type'        => 'sale',
    'timestamp_utc'   => 1501163536,
    'timestamp_local' => 1501163536,
    'email'           => 'customer@gmail.com',
    'phone'           => '+79781234567',
    'tax_system'      => 'OSN',
    'call_back_uri'   => 'http://www.roga-kopita.org/response',
    'inn'             => '123456789111',
    'payment_address' => 'www.roga-kopita.org',
    'items'           => [
        [
            'name'     => 'Товар 1',
            'price'    => '10.99',
            'quantity' => 2,
            'sum'      => '21.98',
            'tax'      => 'vat18',
            'tax_sum'  => '3.956'
        ],
        [
            'name'     => 'Товар 2',
            'price'    => '5.99',
            'quantity' => 3,
            'sum'      => '2.02',
            'tax'      => 'vat18',
            'tax_sum'  => '3.6'
        ]
    ],
    'total'           => '60.89'
];

$timestampUts = (new DateTime())->setTimestamp($documentArray['timestamp_utc']);
$timestampLocal = (new DateTime())->setTimestamp($documentArray['timestamp_local']);

try {
    $taxSystem = TaxesFabric::buildFromCode($documentArray['tax_system']);
} catch (InvalidTaxCodeException $exception) {
    print $exception->getMessage() . PHP_EOL;
    $log->error('rarus.online.kkt.service.getDocument', ['error_message' => $exception->getMessage()]);
    exit();
}

$user = new User(1, (string)$documentArray['phone'], (string)$documentArray['email']);

$serviceTransport = new ServiceTransport($apiClient, $log);
$serviceTransportDto = $serviceTransport->getVersions('versions', 'get');


//==============================
$versions = [];

foreach ($serviceTransportDto as $item) {
    $versions[] = $item;
}


$versionDto = $versions[1];

if (count($versions) === 1) {
    $versionDto = $versions[0];
}
//==============================

$currencies = new ISOCurrencies();
$moneyParser = new DecimalMoneyParser($currencies);
$formatter = new DecimalMoneyFormatter($currencies);

$total = $moneyParser->parse($documentArray['total'], 'RUB');

$productCollection = new ProductCollection();

foreach ((array)$documentArray['items'] as $product) {
    $money = $moneyParser->parse($product['price'], 'RUB');
    $price = $moneyParser->parse($product['price'], 'RUB');
    $taxSum = $moneyParser->parse($product['tax_sum'], 'RUB');
    $priceSum = $moneyParser->parse($product['sum'], 'RUB');

    $productDto = new Product(
        (string)$product['name'],
        $money,
        (int)$product['quantity'],
        $priceSum,
        (string)$product['tax'],
        $taxSum
    );

    $productCollection->attach($productDto, $product);
}

$documentDTO = new Document(
    (string)$documentArray['id'],
    (string)$documentArray['doc_type'],
    $timestampUts,
    $timestampLocal,
    $taxSystem,
    $user,
    (string)$documentArray['call_back_uri'],
    (string)$documentArray['inn'],
    (string)$documentArray['payment_address'],
    $total,
    $productCollection
);

$queueTransport = new QueueTransport($apiClient, $versionDto, $log);
$operationStateDto = $queueTransport->addDocument($documentDTO);

$log->info('rarus.online.kkt.service.getDocument', [
    'apiResult'         => $operationStateDto,
    'operationStateDto' => $operationStateDto->toArray()
]);

print('object OperationState' . PHP_EOL);
print(sprintf(' -operation_id: %s' . PHP_EOL, $operationStateDto->getExternalOperationId()));
print(sprintf(' -timestamp_utc: %s' . PHP_EOL, $operationStateDto->getTimestampUtc()));
print(sprintf(' -status: %s' . PHP_EOL, $operationStateDto->getStatus()));
print(sprintf(' -message: %s' . PHP_EOL, $operationStateDto->getMessage()));
