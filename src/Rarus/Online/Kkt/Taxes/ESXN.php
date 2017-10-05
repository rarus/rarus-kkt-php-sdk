<?php
/**
 * Класс описывает объект "Единый сельскохозяйственный налог"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class ESXN
 *
 * @package Rarus\Online\Kkt\Taxes
 */
class ESXN extends AbstractTax
{
    /**
     * @var string символьный код налогообложения
     */
    protected $taxCode = 'ESXN';
    /**
     * @var string наименование налогообложения
     */
    protected $taxName = 'Единый сельскохозяйственный налог';
}
