<?php
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

use Rarus\Online\Kkt\Exception\InvalidTaxCodeException;

/**
 * Class TaxesFabric
 *
 * @package Rarus\Online\Kkt\Taxes
 */
class TaxesFabric
{
    /**
     * @param string $taxCode
     *
     * @return \Rarus\Online\Kkt\Taxes\TaxInterface
     * @throws \Rarus\Online\Kkt\Exception\InvalidTaxCodeException
     */
    public static function buildFromCode(string $taxCode): TaxInterface
    {
        switch ($taxCode) {
            case $taxCode === 'OSN':
                $taxSystem = new OSN();
                break;
            case $taxCode === 'USN':
                $taxSystem = new USN();
                break;
            case $taxCode === 'PNS':
                $taxSystem = new PSN();
                break;
            case $taxCode === 'ENDV':
                $taxSystem = new ENVD();
                break;
            case $taxCode === 'ESXN':
                $taxSystem = new ESXN();
                break;
            default:
                throw new InvalidTaxCodeException(\sprintf('incorrect tax code [%s]', $taxCode));
        }

        return $taxSystem;
    }
}
