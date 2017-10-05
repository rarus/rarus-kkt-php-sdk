<?php
/**
 * Класс описывает объект "Патентная система налогообложения"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class PSN
 *
 * @package Rarus\Online\Kkt\Taxes
 */
class PSN extends AbstractTax
{
    /**
     * @var string символьный код налогообложения
     */
    protected $taxCode = 'PSN';
    /**
     * @var string наименование налогообложения
     */
    protected $taxName = 'Патентная система налогообложения';
}
