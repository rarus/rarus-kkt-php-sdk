<?php
/**
 * Абстрактный класс сущности "фискализация"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Money;

/**
 * Class AbstractFiscalisation
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
abstract class AbstractFiscalisation
{
    /**
     * @var \Money\Money общая сумма налогооблажения
     */
    protected $total;
    /**
     * @var int номер чека
     */
    protected $fiscalNumber;
    /**
     * @var int фискальный номер
     */
    protected $shiftFiscalNumber;
    /**
     * @var string
     */
    protected $receiptDate; //todo DateTime
    /**
     * @var string номер чека
     */
    protected $fnNumber;
    /**
     * @var string регистрационный номер kkt
     */
    protected $kktRegistrationNumber;
    /**
     * @var int фискальный атрибут //todo уточнить что это
     */
    protected $fiscalAttribute;
    /**
     * @var int номер фискального документа
     */
    protected $fiscalDocNumber;
    /**
     * @var string адрес сайта fns
     */
    protected $fnsSite;
    /**
     * @var string Кредит
     */
    protected $credit;
    /**
     * @var string Аванс
     */
    protected $advancePayment;
    /**
     * @var string Сумма наличными
     */
    protected $cash;
    /**
     * @var string Сумма встречного представления
     */
    protected $barter;
    /**
     * @return \Money\Money
     */
    public function getTotal(): Money
    {
        return $this->total;
    }

    /**
     * @param \Money\Money $total
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AbstractFiscalisation
     */
    protected function setTotal(Money $total): AbstractFiscalisation
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return int
     */
    public function getFiscalNumber(): int
    {
        return $this->fiscalNumber;
    }

    /**
     * @param int $fiscalNumber
     *
     * @return int
     */
    protected function setFiscalNumber(int $fiscalNumber): int
    {
        $this->fiscalNumber = $fiscalNumber;
        return $this->fiscalNumber;
    }

    /**
     * @return int
     */
    public function getShiftFiscalNumber(): int
    {
        return $this->shiftFiscalNumber;
    }

    /**
     * @param int $shiftFiscalNumber
     *
     * @return AbstractFiscalisation
     */
    protected function setShiftFiscalNumber(int $shiftFiscalNumber): AbstractFiscalisation
    {
        $this->shiftFiscalNumber = $shiftFiscalNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getReceiptDate(): string //todo \DateTime
    {
        return $this->receiptDate;
    }

    /**
     * @param string $receiptDate
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AbstractFiscalisation
     */
    protected function setReceiptDate(string $receiptDate): AbstractFiscalisation //todo \DateTime
    {
        $this->receiptDate = $receiptDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getFnNumber(): string
    {
        return $this->fnNumber;
    }

    /**
     * @param string $fnNumber
     *
     * @return AbstractFiscalisation
     */
    protected function setFnNumber(string $fnNumber): AbstractFiscalisation
    {
        $this->fnNumber = $fnNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getKktRegistrationNumber(): string
    {
        return $this->kktRegistrationNumber;
    }

    /**
     * @param string $kktRegistrationNumber
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AbstractFiscalisation
     */
    protected function setKktRegistrationNumber(string $kktRegistrationNumber): AbstractFiscalisation
    {
        $this->kktRegistrationNumber = $kktRegistrationNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getFiscalAttribute(): int
    {
        return $this->fiscalAttribute;
    }

    /**
     * @param int $fiscalAttribute
     *
     * @return AbstractFiscalisation
     */
    protected function setFiscalAttribute(int $fiscalAttribute): AbstractFiscalisation
    {
        $this->fiscalAttribute = $fiscalAttribute;
        return $this;
    }

    /**
     * @return int
     */
    public function getFiscalDocNumber(): int
    {
        return $this->fiscalDocNumber;
    }

    /**
     * @param int $fiscalDocNumber
     *
     * @return AbstractFiscalisation
     */
    protected function setFiscalDocNumber(int $fiscalDocNumber): AbstractFiscalisation
    {
        $this->fiscalDocNumber = $fiscalDocNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getFnsSite(): string
    {
        return $this->fnsSite;
    }

    /**
     * @param string $fnsSite
     *
     * @return AbstractFiscalisation
     */
    protected function setFnsSite(string $fnsSite): AbstractFiscalisation
    {
        $this->fnsSite = $fnsSite;
        return $this;
    }

    /**
     * @return string
     */
    public function getCredit() :string
    {
        return $this->credit;
    }

    /**
     * @param string $credit
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AbstractFiscalisation
     */
    protected function setCredit(string $credit): AbstractFiscalisation
    {
        $this->credit = $credit;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdvancePayment() :string
    {
        return $this->advancePayment;
    }

    /**
     * @param string $advancePayment
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AbstractFiscalisation
     */
    protected function setAdvancePayment(string $advancePayment): AbstractFiscalisation
    {
        $this->advancePayment = $advancePayment;
        return $this;
    }

    /**
     * @return string
     */
    public function getCash() :string
    {
        return $this->cash;
    }

    /**
     * @param string $cash
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AbstractFiscalisation
     */
    protected function setCash(string $cash): AbstractFiscalisation
    {
        $this->cash = $cash;
        return $this;
    }

    /**
     * @return string
     */
    public function getBarter() :string
    {
        return $this->barter;
    }

    /**
     * @param string $barter
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AbstractFiscalisation
     */
    protected function setBarter(string $barter): AbstractFiscalisation
    {
        $this->barter = $barter;
        return $this;
    }
}
