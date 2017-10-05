<?php
/**
 * Пример создания объекта ProductCollection
 * Описывает пример создания коллекции объектов DTO Product.
 *
 * Предназначен для передачи элемента документа "items" в соответствующую очередь
 * для последующей передачи на ККТ
 *
 * Описывает пример результата отправки документа на обработку
 */
declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\Online\Kkt\{
    Queue\DTO\Product,
    Queue\DTO\ProductCollection
};
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

$products = [
    [
        'name'     => 'Товар 1',
        //'price'    => 10.99,
        'price'    => '10.9943894',
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
];

$productCollection = new ProductCollection();

$currencies = new ISOCurrencies();
$moneyParser = new DecimalMoneyParser($currencies);

$log->info('rarus.online.kkt.service.ProductCollection.start');

foreach ((array)$products as $product) {
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

    $log->info('rarus.online.kkt.service.productDTO', [
        'productDto' => $productDto->toArray()
    ]);

    print('object Product ' . PHP_EOL);
    print(sprintf(' -name: %s' . PHP_EOL, $productDto->getName()));
    print(sprintf(' -price: %s' . PHP_EOL, $productDto->getPrice()->getAmount()));
    print(sprintf(' -quantity: %s' . PHP_EOL, $productDto->getQuantity()));
    print(sprintf(' -sum: %s' . PHP_EOL, $productDto->getSum()->getAmount()));
    print(sprintf(' -tax: %s' . PHP_EOL, $productDto->getTax()));
    print(sprintf(' -tax_sum: %s' . PHP_EOL, $productDto->getTaxSum()->getAmount()));
}

$log->info('rarus.online.kkt.service.ProductCollection.finish');
