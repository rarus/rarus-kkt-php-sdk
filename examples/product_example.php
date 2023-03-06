<?php
/**
 * Пример создания DTO объекта Product
 */
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use libphonenumber\PhoneNumberUtil;
use Money\Currency;
use Rarus\Online\Kkt\{Queue\DTO\AgentInfo,
    Queue\DTO\AgentInfoPaymentAgent,
    Queue\DTO\AgentInfoPaymentAgentInfoOperation,
    Queue\DTO\AgentInfoPaymentAgentInfoTypeValue,
    Queue\DTO\AgentInfoPaymentTransferInfo,
    Queue\DTO\Inn,
    Queue\DTO\Product,
    Queue\DTO\SupplierInfo};

use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Money\Formatter\DecimalMoneyFormatter;
use Rarus\OnlineKkt\Log;


$product = [
    'name'     => 'Товар 1',
    'price'    => '10.9943894', //99
    //'price'    => 10.99,
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
    'customs_declaration' => 'тег 1231 Номер таможенной декларации',
    'marking_code' => '0108019227246674215:md7Ehwwhpdy<0x1D>91ee08<0x1D>92ybeylJbht8LhsXDca+U4akz+ugzpvidwTipcVuZwZ0e=', //код маркировки
    'planned_status' => 1, //планируемый статус товара
    'measure_quantity' => 11 //мера количества предмета расчета
];

$currencies = new ISOCurrencies();

$moneyParser = new DecimalMoneyParser($currencies);
$formatter = new DecimalMoneyFormatter($currencies);

$price = $moneyParser->parse($product['price'], 'RUB');
$taxSum = $moneyParser->parse($product['tax_sum'], 'RUB');
$priceSum = $moneyParser->parse($product['sum'], 'RUB');

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
    $price,
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

$log->info('rarus.online.kkt.service.DocumentDTO', [
    'productDto' => $productDto->toArray()
]);

print('object ZReports ' . PHP_EOL);
print(sprintf(' -name: %s' . PHP_EOL, $productDto->getName()));
print(sprintf(' -price: %s' . PHP_EOL, $productDto->getPrice()->getAmount()));
print(sprintf(' -quantity: %s' . PHP_EOL, $productDto->getQuantity()));
print(sprintf(' -sum: %s' . PHP_EOL, $productDto->getSum()->getAmount()));
print(sprintf(' -tax: %s' . PHP_EOL, $productDto->getTax()));
print(sprintf(' -tax_sum: %s' . PHP_EOL, $productDto->getTaxSum()->getAmount()));
print(sprintf(' -sign_method_calculation: %s' . PHP_EOL, $productDto->getSignMethodCalculation()));
print(sprintf(' -sign_calculation_object: %s' . PHP_EOL, $productDto->getSignCalculationObject()));
print(sprintf(' -user_data: %s' . PHP_EOL, $productDto->getUserData()));
print(sprintf(' -measurement_unit: %s' . PHP_EOL, $productDto->getMeasurementUnit()));
print(sprintf(' -stamp_type: %s' . PHP_EOL, $productDto->getStampType()));
print(sprintf(' -GTIN: %s' . PHP_EOL, $productDto->getGtin()));
print(sprintf(' -serial_number: %s' . PHP_EOL, $productDto->getSerialNumber()));
print(sprintf(' -customs_declaration: %s' . PHP_EOL, $productDto->getCustomsDeclarationNumber()));
print('-agent_info:' . PHP_EOL . Var_export( $productDto->getAgentInfo()->toArray()));
print('-supplier_info:' . PHP_EOL . Var_export( $productDto->getSupplierInfo()->toArray()));
print(sprintf(' -marking_code: %s' . PHP_EOL, $productDto->getMarkingCode()));
print(sprintf(' -planned_status: %s' . PHP_EOL, $productDto->getPlannedStatus()));
print(sprintf(' -measure_quantity: %s' . PHP_EOL, $productDto->getMeasureQuantity()));
