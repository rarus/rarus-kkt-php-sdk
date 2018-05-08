<?php
/**
 * Класс описывает объект "'УСНО (доходы минус расходы )'"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class USNDR
 *
 * @package Rarus\Online\Kkt\Taxes
 */
class USNDR extends AbstractTax
{
    /**
     * @var string символьный код налогообложения
     */
    protected $taxCode = 'USNDR';

    /**
     * @var string наименование налогообложения
     */
    protected $taxName = 'УСНО (доходы минус расходы)';
}
