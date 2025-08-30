<?php

declare(strict_types=1);
/**
 * Пример создания объекта OperationState
 * Описывает метод document сервиса онлайн касс
 *
 * Описывает пример результата отправки документа на обработку
 */


require_once __DIR__ . '/init.php';

use libphonenumber\PhoneNumberUtil;
use Rarus\Online\Kkt\{Queue\DTO\AgentInfo,
    Queue\DTO\AgentInfoPaymentAgent,
    Queue\DTO\AgentInfoPaymentAgentInfoOperation,
    Queue\DTO\AgentInfoPaymentAgentInfoTypeValue,
    Queue\DTO\AgentInfoPaymentTransferInfo,
    Queue\DTO\Inn,
    Queue\DTO\SupplierInfo,
    Queue\DTO\User,
    Queue\DTO\Product,
    Queue\DTO\Document,
    Queue\DTO\ProductCollection,
    Queue\Transport as QueueTransport,
    Service\Transport as ServiceTransport};
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use Rarus\Online\Kkt\Exception\InvalidTaxCodeException;
use Rarus\Online\Kkt\Taxes\TaxesFabric;

global $log;
global $apiClient;

$documentArray = [
    // На каждый запуск примера должен быть новый id
    // id может не быть. Параметр не обязательный.
    // Если id нет, то просто не указываем его.
    //'id'              => '496DEF23-EBB3-4A24-8F23-AE709BE81308',
    'doc_type'               => 'sale',
    'timestamp_utc'          => 1501163536,
    'timestamp_local'        => 1501163536,
    'email'                  => 'customer@gmail.com',
    'phone'                  => '+79781234567',
    'tax_system'             => 'OSN',
    'call_back_uri'          => 'https://www.roga-kopita.org/response',
    'inn'                    => '123456789111',
    'payment_address'        => 'www.roga-kopita.org',
    'items'                  => [
        [
            'name'     => 'Товар 1',
            'price'    => '10.99',
            'quantity' => 2,
            'sum'      => '21.98',
            'tax'      => 'vat20',
            'tax_sum'  => '3.956',

            'sign_method_calculation' => 'partial_payment',
            'sign_calculation_object' => 'property_right',
            'agent_info' => [
                'type' => 'payment_agent',
                'payment_agent_info' => [
                    'operation' => 'Наименование операции',
                    'phone' => '79789999999'
                ],
                'payment_acceptor_info' => [
                    'phone' => '79789999888'
                ],
                'payment_transfer_info' => [
                    'name' => 'Наименование оператора перевода',
                    'phone' => '79789999777',
                    'address' => 'www.operator',
                    'inn' => '1234567890'
                ]
            ],
            'supplier_info' => [
                'name' => 'Поставщик',
                'phone' => '79789999966',
                'inn' => '1234567866'
            ],
            'user_data' => 'test-user_data',
            'measurement_unit' => 'тег 1197 Единица измерения',
            'stamp_type' => 'Тип маркировки',
            'GTIN' => 'Глобальный идентификатор торговой единицы',
            'serial_number' => 'Серийный номер',
            'customs_declaration' => 'тег 1231 Номер таможенной декларации'
        ],
        [
            'name'     => 'tovar_nmae',
            'price'    =>  '779',
            'quantity' => 1,
            'sum'      => '779',
            'tax'      => 'vat10',
            'tax_sum'  => '70.82',
            'sign_method_calculation' => '',
            'sign_calculation_object' => '',
            'agent_info' => [
                'type' => '',
                'payment_agent_info' => [
                    'operation' => '',
                    'phone' => ''
                ],
                'payment_acceptor_info' => [
                    'phone' => ''
                ],
                'payment_transfer_info' => [
                    'name' => '',
                    'phone' => '',
                    'address' => '',
                    'inn' => ''
                ]
            ],
            'supplier_info' => [
                'name' => '',
                'phone' => '',
                'inn' => ''
            ],
            'user_data' => '',
            'measurement_unit' => '',
            'stamp_type' => '',
            'GTIN' => '',
            'serial_number' => '',
            'customs_declaration' => ''
        ],
        [
            'name'     => 'tovar3_nmae',
            'price'    =>  '779',
            'quantity' => 1,
            'sum'      => '779',
            'tax'      => 'vat10',
            'tax_sum'  => '70.82',
            'sign_method_calculation' => 'partial_payment',
            'sign_calculation_object' => 'property_right',
            'agent_info' => [
                'type' => 'payment_agent',
                'payment_agent_info' => [
                    'operation' => 'operation-name',
                    'phone' => '79789999999'
                ],
                'payment_acceptor_info' => [
                    'phone' => '79789999888'
                ],
                'payment_transfer_info' => [
                    'name' => 'operator_name',
                    'phone' => '79789999777',
                    'address' => 'www.operator',
                    'inn' => '1234567890'
                ]
            ],
            'supplier_info' => [
                'name' => 'supplier-name-item',
                'phone' => '79789999966',
                'inn' => '1234567866'
            ],
            'user_data' => 'test-user_data',
            'measurement_unit' => 'kg',
            'stamp_type' => '3111',
            'GTIN' => '12121213232',
            'serial_number' => '37777',
            'customs_declaration' => '8888888',
            'marking_code' => '0108019227246674215:md7Ehwwhpdy<0x1D>91ee08<0x1D>92ybeylJbht8LhsXDca+U4akz+ugzpvidwTipcVuZwZ0e=', //код маркировки
            'planned_status' => 1, //планируемый статус товара
            'measure_quantity' => 11 //мера количества предмета расчета
        ]
    ],
    'total'                  => '60.89',
    'agent_info'             => [
        'type'                  => 'payment_agent',
        'payment_agent_info'    => [
            'operation' => 'testoperation',
            'phone'     => '79789999555'
        ],
        'payment_acceptor_info' => [
            'phone' => '79789999444'
        ],
        'payment_transfer_info' => [
            'name'    => 'nametest',
            'phone'   => '79789999333',
            'address' => 'www.operator',
            'inn'     => '1234567890'
        ]
    ],
    'supplier_info'          => [
        'name'  => 'test-supplier-name',
        'phone' => '79789999222',
        'inn'   => '1212121221'
    ],
    'cashier'                => 'test-cashier',
    'additional_check_props' => 'test-additionalCheckProp',
    'customer_info'          => 'test-customerInfo',
    'customer_inn'           => '1212121212',
    'tag_1085'               => 'test-testtag_1085',
    'tag_1086'               => 'test-testtag_1086',
    'credit'                 => '60.89',
    'advance_payment'        => '11.22',
    'cash'                   => '33.44',
    'barter'                 => '55'
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
$moneyCurrency = new Currency('RUB');

$total = $moneyParser->parse($documentArray['total'], $moneyCurrency);

$productCollection = new ProductCollection();

foreach ((array)$documentArray['items'] as $product) {
    $money = $moneyParser->parse($product['price'], $moneyCurrency);
    $price = $moneyParser->parse($product['price'], $moneyCurrency);
    $taxSum = $moneyParser->parse($product['tax_sum'], $moneyCurrency);
    $priceSum = $moneyParser->parse($product['sum'], $moneyCurrency);

    if (!empty($product['agent_info']['type'])) {
        $type = strtoupper($product['agent_info']['type']);
        $agentInfoPaymentAgentType = AgentInfoPaymentAgentInfoTypeValue::$type();
    } else {
        $agentInfoPaymentAgentType = null;
    }

    $AgentInfoPaymentAgentInfoOperation = new AgentInfoPaymentAgentInfoOperation(
        $product['agent_info']['payment_agent_info']['operation']
    );

    if (!empty($product['agent_info']['payment_agent_info']['phone'])) {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $AgentInfoPaymentAgentInfoPhone = $phoneUtil->parse($product['agent_info']['payment_agent_info']['phone'], "RU");
    } else {
        $AgentInfoPaymentAgentInfoPhone = null;
    }

    $paymentAgentInfo = new AgentInfoPaymentAgent(
        $AgentInfoPaymentAgentInfoOperation,
        $AgentInfoPaymentAgentInfoPhone
    );

    if (!empty($product['agent_info']['payment_acceptor_info']['phone'])) {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $paymentAcceptorInfoPhone = $phoneUtil->parse($product['agent_info']['payment_acceptor_info']['phone'], "RU");
    } else {
        $paymentAcceptorInfoPhone = null;
    }

    if (!empty($product['agent_info']['payment_transfer_info']['phone'])) {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $paymentTransferInfoPhone = $phoneUtil->parse($product['agent_info']['payment_transfer_info']['phone'], "RU");
    } else {
        $paymentTransferInfoPhone = null;
    }

    $paymentTransferInfoInn = new Inn($product['agent_info']['payment_transfer_info']['inn']);

    $paymentTransferInfo = new AgentInfoPaymentTransferInfo(
        (string)$product['agent_info']['payment_transfer_info']['name'],
        $paymentTransferInfoPhone,
        (string)$product['agent_info']['payment_transfer_info']['address'],
        $paymentTransferInfoInn
    );

    $agentInfoDto = new AgentInfo(
        $agentInfoPaymentAgentType,
        $paymentAgentInfo,
        $paymentAcceptorInfoPhone,
        $paymentTransferInfo
    );

    $innItem = new Inn($product['supplier_info']['inn']);

    $supplierInfoDtoItem = new SupplierInfo(
        (string)$product['supplier_info']['name'],
        (string)$product['supplier_info']['phone'],
        $innItem
    );

    $productDto = new Product(
        (string)$product['name'],
        $money,
        (float)$product['quantity'],
        $priceSum,
        (string)$product['tax'],
        $taxSum,
        (string)$product['sign_method_calculation'],
        (string)$product['sign_calculation_object'],
        (string)$product['user_data'],
        (string)$product['measurement_unit'],
        (string)$product['stamp_type'],
        (string)$product['GTIN'],
        (string)$product['serial_number'],
        (string)$product['customs_declaration'],
        $agentInfoDto,
        $supplierInfoDtoItem,
        (string)$product['marking_code'],
        (int)$product['planned_status'],
        (int)$product['measure_quantity']
    );

    $productCollection->attach($productDto, $product);
}

if(!empty($documentArray['agent_info']['type'])) {
    $type = strtoupper($documentArray['agent_info']['type']);
    $agentInfoPaymentAgentType = AgentInfoPaymentAgentInfoTypeValue::$type();
} else {
    $agentInfoPaymentAgentType = null;
}

$AgentInfoPaymentAgentInfoOperation = new AgentInfoPaymentAgentInfoOperation(
    $documentArray['agent_info']['payment_agent_info']['operation']
);

//libphonenumber'price'    => '10.99',
if (!empty($documentArray['agent_info']['payment_agent_info']['phone'])) {
    $phoneUtil = PhoneNumberUtil::getInstance();
    $AgentInfoPaymentAgentInfoPhone = $phoneUtil->parse($documentArray['agent_info']['payment_agent_info']['phone'], "RU");
} else {
    $AgentInfoPaymentAgentInfoPhone = null;
}

$paymentAgentInfo = new AgentInfoPaymentAgent(
    $AgentInfoPaymentAgentInfoOperation,
    $AgentInfoPaymentAgentInfoPhone
);

if (!empty($documentArray['agent_info']['payment_acceptor_info']['phone'])) {
    $phoneUtil = PhoneNumberUtil::getInstance();
    $paymentAcceptorInfoPhone = $phoneUtil->parse($documentArray['agent_info']['payment_acceptor_info']['phone'], "RU");
} else {
    $paymentAcceptorInfoPhone = null;
}

if (!empty($documentArray['agent_info']['payment_transfer_info']['phone'])) {
    $phoneUtil = PhoneNumberUtil::getInstance();
    $paymentTransferInfoPhone = $phoneUtil->parse($documentArray['agent_info']['payment_transfer_info']['phone'], "RU");
} else {
    $paymentTransferInfoPhone = null;
}

$paymentTransferInfoInn = new Inn($documentArray['agent_info']['payment_transfer_info']['inn']);

$paymentTransferInfo = new AgentInfoPaymentTransferInfo(
    (string)$documentArray['agent_info']['payment_transfer_info']['name'],
    $paymentTransferInfoPhone,
    (string)$documentArray['agent_info']['payment_transfer_info']['address'],
    $paymentTransferInfoInn
);

$agentInfoDto = new AgentInfo(
    $agentInfoPaymentAgentType,
    $paymentAgentInfo,
    $paymentAcceptorInfoPhone,
    $paymentTransferInfo
);

$credit = $moneyParser->parse((string)$documentArray['credit'], $moneyCurrency);
$advance_payment = $moneyParser->parse((string)$documentArray['advance_payment'], $moneyCurrency);
$cash = $moneyParser->parse((string)$documentArray['cash'], $moneyCurrency);
$barter = $moneyParser->parse((string)$documentArray['barter'], $moneyCurrency);

$innDoc = new Inn($documentArray['supplier_info']['inn']);
$supplierInfoDto = new SupplierInfo(
    $documentArray['supplier_info']['name'],
    $documentArray['supplier_info']['phone'],
    $innDoc
);

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
    $productCollection,
    $agentInfoDto,
    $supplierInfoDto,
    (string)$documentArray['cashier'],
    (string)$documentArray['additional_check_props'],
    (string)$documentArray['customer_info'],
    (string)$documentArray['customer_inn'],
    (string)$documentArray['tag_1085'],
    (string)$documentArray['tag_1086'],
    $credit,
    $advance_payment,
    $cash,
    $barter
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
