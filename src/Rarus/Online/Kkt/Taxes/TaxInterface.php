<?php
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

/**
 * Class AbstractTax
 *
 * @package Rarus\Online\Kkt\Taxes
 */
interface TaxInterface
{
    /**
     * @return string
     */
    public function getTaxName(): string;

    /**
     * @return string
     */
    public function getTaxCode(): string;
}
