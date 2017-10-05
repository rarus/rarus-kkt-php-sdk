<?php
/**
 * Класс описывает DTO объект товара
 * Создается в клиентском коде
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Money;

/**
 * Class Product
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class Product
{
    /**
     * @var string наименование товара
     */
    protected $name;
    /**
     * @var Money цена за единицу товара
     */
    protected $price;
    /**
     * @var int количество приобретенного товара
     */
    protected $quantity;
    /**
     * @var Money сумма товара
     */
    protected $sum;
    /**
     * @var string ставки НДС
     */
    protected $tax;
    /**
     * @var Money цена за единицу товара
     */
    protected $taxSum;

    /**
     * Product constructor.
     *
     * @param string       $name
     * @param \Money\Money $price
     * @param int          $quantity
     * @param \Money\Money $sum
     * @param string       $tax
     * @param \Money\Money $taxSum
     */
    public function __construct(
        string $name,
        Money $price,
        int $quantity,
        Money $sum,
        string $tax,
        Money $taxSum
    ) {
        $this->setName($name);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setSum($sum);
        $this->setTax($tax);
        $this->setTaxSum($taxSum);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'     => $this->getName(),
            'price'    => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'sum'      => $this->getSum(),
            'tax'      => $this->getTax(),
            'tax_sum'  => $this->getTaxSum()
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Product
     */
    protected function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @param \Money\Money $price
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setPrice(Money $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return Product
     */
    protected function setQuantity(int $quantity): Product
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return Money
     */
    public function getSum(): Money
    {
        return $this->sum;
    }

    /**
     * @param \Money\Money $sum
     *
     * @return Product
     */
    protected function setSum(Money $sum): Product
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * @return string
     */
    public function getTax(): string
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     *
     * @return Product
     */
    protected function setTax(string $tax): Product
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return Money
     */
    public function getTaxSum(): Money
    {
        return $this->taxSum;
    }

    /**
     * @param \Money\Money $taxSum
     *
     * @return Product
     */
    protected function setTaxSum(Money $taxSum): Product
    {
        $this->taxSum = $taxSum;
        return $this;
    }
}
