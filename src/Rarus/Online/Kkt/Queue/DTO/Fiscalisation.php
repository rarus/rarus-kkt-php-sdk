<?php
/**
 * Класс описывает DTO объект сущности Fiscalisation
 * Документ фискализации
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Money;

/**
 * Class TrueAbstractFiscalisation
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class Fiscalisation extends AbstractFiscalisation
{
    /**
     * Fiscalisation constructor.
     *
     * @param \Money\Money $total
     * @param int          $fiscalNumber
     * @param int          $shiftFiscalNumber
     * @param string       $receiptDate
     * @param string       $fnNumber
     * @param string       $kktRegistrationNumber
     * @param int          $fiscalAttribute
     * @param int          $fiscalDocNumber
     * @param string       $fnsSite
     */
    public function __construct(
        Money $total,
        int $fiscalNumber,
        int $shiftFiscalNumber,
        // \DateTime $receiptDate, //todo пока что строка
        string $receiptDate,
        string $fnNumber,
        string $kktRegistrationNumber,
        int $fiscalAttribute,
        int $fiscalDocNumber,
        string $fnsSite
    ) {
        $this->setTotal($total);
        $this->setFiscalNumber($fiscalNumber);
        $this->setShiftFiscalNumber($shiftFiscalNumber);
        $this->setReceiptDate($receiptDate);
        $this->setFnNumber($fnNumber);
        $this->setKktRegistrationNumber($kktRegistrationNumber);
        $this->setFiscalAttribute($fiscalAttribute);
        $this->setFiscalDocNumber($fiscalDocNumber);
        $this->setFnsSite($fnsSite);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'total'                   => $this->getTotal()->getAmount(),
            'fiscal_number'           => $this->getFiscalNumber(),
            'shift_fiscal_number'     => $this->getShiftFiscalNumber(),
            'receipt_date'            => $this->getReceiptDate(),
            'fn_number'               => $this->getFnNumber(),
            'kkt_registration_number' => $this->getKktRegistrationNumber(),
            'fiscal_attribute'        => $this->getFiscalAttribute(),
            'fiscal_doc_number'       => $this->getFiscalDocNumber(),
            'fns_site'                => $this->getFnsSite()
        ];
    }
}
