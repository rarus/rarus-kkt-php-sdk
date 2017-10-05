<?php
/**
 * Класс описывает объект "Общая система налогообложения"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class OSN
 *
 * @package Rarus\Online\Kkt\Taxes
 */
class OSN extends AbstractTax
{
    /**
     * @var string символьный код налогообложения
     */
    protected $taxCode = 'OSN';
    /**
     * @var string наименование налогообложения
     */
    protected $taxName = 'Общая система налогообложения';
}
