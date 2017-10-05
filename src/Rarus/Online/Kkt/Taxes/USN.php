<?php
/**
 * Класс описывает объект "Упрощенная система налогообложения"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class OSN
 *
 * @package Rarus\Online\Kkt\Taxes
 */
class USN extends AbstractTax
{
    /**
     * @var string символьный код налогообложения
     */
    protected $taxCode = 'USN';
    /**
     * @var string наименование налогообложения
     */
    protected $taxName = 'Упрощенная система налогообложения';
}
