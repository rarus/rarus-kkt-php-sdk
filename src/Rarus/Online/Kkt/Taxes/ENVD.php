<?php
/**
 * Класс описывает объект "Единый налог на вменённый доход"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class ENVD
 *
 * @package Rarus\Online\Kkt\Taxes
 */
class ENVD extends AbstractTax
{
    /**
     * @var string символьный код налогообложения
     */
    protected $taxCode = 'ENVD';
    /**
     * @var string наименование налогообложения
     */
    protected $taxName = 'Единый налог на вменённый доход';
}
