<?php
declare(strict_types=1);

namespace Rarus\Online\Kkt\Taxes;

use Rarus\Online\Kkt\Exception\InvalidTaxCodeException;

use function sprintf;

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
            case $taxCode === 'PSN':
                $taxSystem = new PSN();
                break;
            case $taxCode === 'ENVD':
                $taxSystem = new ENVD();
                break;
            case $taxCode === 'ESXN':
                $taxSystem = new ESXN();
                break;
            case $taxCode === 'USNDR':
                $taxSystem = new USNDR();
                break;
            default:
                throw new InvalidTaxCodeException(sprintf('incorrect tax code [%s]', $taxCode));
        }

        return $taxSystem;
    }
}
