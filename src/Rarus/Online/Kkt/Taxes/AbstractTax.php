<?php
/**
 * Абстрактный класс описывающий сущности
 * систем налогообложения
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class AbstractTax
 *
 * @package Rarus\Online\Kkt\Taxes
 */
abstract class AbstractTax implements TaxInterface
{
    /**
     * @var string наименование налогообложения
     */
    protected $taxName;

    /**
     * @var string символьный код налогообложения
     */
    protected $taxCode;

    /**
     * @return string
     */
    public function getTaxName(): string
    {
        return $this->taxName;
    }

    /**
     * @param string $taxName
     *
     * @return AbstractTax
     */
    protected function setTaxName(string $taxName): AbstractTax
    {
        $this->taxName = $taxName;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxCode(): string
    {
        return $this->taxCode;
    }

    /**
     * @param string $taxCode
     *
     * @return AbstractTax
     */
    protected function setTaxCode(string $taxCode): AbstractTax
    {
        $this->taxCode = $taxCode;
        return $this;
    }
}
