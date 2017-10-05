<?php
/**
 * Класс описывает объект "Единый налог на вменённый доход"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class ENDV
 *
 * @package Rarus\Online\Kkt\Taxes
 */
class ENVD extends AbstractTax
{
    /**
     * @var string символьный код налогообложения
     */
    protected $taxCode = 'ENCD';
    /**
     * @var string наименование налогообложения
     */
    protected $taxName = 'Единый налог на вменённый доход';
}
