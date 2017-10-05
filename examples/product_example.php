<?php
/**
 * Пример создания DTO объекта Product
 */
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Money\Currency;
use \Rarus\Online\Kkt\{
    Queue\DTO\Product
};

use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Money\Formatter\DecimalMoneyFormatter;


$product = [
    'name'     => 'Товар 1',
    'price'    => '10.9943894', //99
    //'price'    => 10.99,
    'quantity' => 2,
    'sum'      => '21.98',
    'tax'      => 'vat18',
    'tax_sum'  => '3.956'
];

$currencies = new ISOCurrencies();

$moneyParser = new DecimalMoneyParser($currencies);
$formatter = new DecimalMoneyFormatter($currencies);

$price = $moneyParser->parse($product['price'], 'RUB');
$taxSum = $moneyParser->parse($product['tax_sum'], 'RUB');
$priceSum = $moneyParser->parse($product['sum'], 'RUB');

$productDto = new Product(
    (string)$product['name'],
    $price,
    (int)$product['quantity'],
    $priceSum,
    (string)$product['tax'],
    $taxSum
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
