<?php
/**
 * Класс описывает DTO Объект документа
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Money;
use Rarus\Online\Kkt\Taxes\TaxInterface;

/**
 * Class Document
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class Document
{
    /**
     * @var string внешний id документа
     */
    protected $externalId;
    /**
     * @var string тип документа
     */
    protected $docType;
    /**
     * @var \DateTime
     */
    protected $timestampUtc;
    /**
     * @var \DateTime
     */
    protected $timestampLocal;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\User
     */
    protected $user;
    /**
     * @var \Rarus\Online\Kkt\Taxes\AbstractTax
     */
    protected $taxSystem;
    /**
     * @var string адрес ответа
     */
    protected $callBackUri;
    /**
     * @var string ИНН
     */
    protected $inn;
    /**
     * @var string адрес магазина. Например www.roga-kopita.org
     */
    protected $paymentAddress;
    /**
     * @var \Money\Money Итоговая сумма документа
     */
    protected $total;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\ProductCollection
     */
    protected $items;

    /**
     * Document constructor.
     *
     * @param string                                        $externalId
     * @param string                                        $docType
     * @param \DateTime                                     $timestampUtc
     * @param \DateTime                                     $timestampLocal
     * @param \Rarus\Online\Kkt\Taxes\TaxInterface          $taxSystem
     * @param \Rarus\Online\Kkt\Queue\DTO\User              $user
     * @param string                                        $callBackUri
     * @param string                                        $inn
     * @param string                                        $paymentAddress
     * @param \Money\Money                                  $total
     * @param \Rarus\Online\Kkt\Queue\DTO\ProductCollection $items
     */
    public function __construct(
        string $externalId,
        string $docType,
        \DateTime $timestampUtc,
        \DateTime $timestampLocal,
        TaxInterface $taxSystem,
        User $user,
        string $callBackUri,
        string $inn,
        string $paymentAddress,
        Money $total,
        ProductCollection $items
    ) {
        $this->setExternalId($externalId);
        $this->setDocType($docType);
        $this->setTimestampUtc($timestampUtc);
        $this->setTimestampLocal($timestampLocal);
        $this->setTaxSystem($taxSystem);
        $this->setUser($user);
        $this->setCallBackUri($callBackUri);
        $this->setInn($inn);
        $this->setPaymentAddress($paymentAddress);
        $this->setTotal($total);
        $this->setItems($items);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'              => $this->getExternalId(),
            'doc_type'        => $this->getDocType(),
            'timestamp_utc'   => $this->getTimestampUtc()->getTimestamp(),
            'timestamp_local' => $this->getTimestampLocal()->getTimestamp(),
            'email'           => $this->getUser()->getEmail(),
            'phone'           => $this->getUser()->getPhone(),
            'tax_system'      => $this->getTaxSystem()->getTaxCode(),
            'call_back_uri'   => $this->getCallBackUri(),
            'inn'             => $this->getInn(),
            'payment_address' => $this->getPaymentAddress(),
            'total'           => $this->getTotal()
        ];
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     *
     * @return Document
     */
    protected function setExternalId(string $externalId): Document
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocType(): string
    {
        return $this->docType;
    }

    /**
     * @param string $docType
     *
     * @return Document
     */
    protected function setDocType(string $docType): Document
    {
        $this->docType = $docType;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimestampUtc(): \DateTime
    {
        return $this->timestampUtc;
    }

    /**
     * @param \DateTime $timestampUtc
     *
     * @return Document
     */
    protected function setTimestampUtc(\DateTime $timestampUtc): Document
    {
        $this->timestampUtc = $timestampUtc;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimestampLocal(): \DateTime
    {
        return $this->timestampLocal;
    }

    /**
     * @param \DateTime $timestampLocal
     *
     * @return Document
     */
    protected function setTimestampLocal(\DateTime $timestampLocal): Document
    {
        $this->timestampLocal = $timestampLocal;
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\User
     */
    public function getUser(): \Rarus\Online\Kkt\Queue\DTO\User
    {
        return $this->user;
    }

    /**
     * @param \Rarus\Online\Kkt\Queue\DTO\User $user
     *
     * @return Document
     */
    protected function setUser(\Rarus\Online\Kkt\Queue\DTO\User $user): Document
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Taxes\TaxInterface
     */
    public function getTaxSystem(): \Rarus\Online\Kkt\Taxes\TaxInterface
    {
        return $this->taxSystem;
    }

    /**
     * @param \Rarus\Online\Kkt\Taxes\TaxInterface $taxSystem
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Document
     */
    protected function setTaxSystem(\Rarus\Online\Kkt\Taxes\TaxInterface $taxSystem): Document
    {
        $this->taxSystem = $taxSystem;
        return $this;
    }

    /**
     * @return string
     */
    public function getCallBackUri(): string
    {
        return $this->callBackUri;
    }

    /**
     * @param string $callBackUri
     *
     * @return Document
     */
    protected function setCallBackUri(string $callBackUri): Document
    {
        $this->callBackUri = $callBackUri;
        return $this;
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @param string $inn
     *
     * @return Document
     */
    protected function setInn(string $inn): Document
    {
        $this->inn = $inn;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentAddress(): string
    {
        return $this->paymentAddress;
    }

    /**
     * @param string $paymentAddress
     *
     * @return Document
     */
    protected function setPaymentAddress(string $paymentAddress): Document
    {
        $this->paymentAddress = $paymentAddress;
        return $this;
    }

    /**
     * @return Money
     */
    public function getTotal(): Money
    {
        return $this->total;
    }

    /**
     * @param Money $total
     *
     * @return Document
     */
    protected function setTotal(Money $total): Document
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\ProductCollection
     */
    public function getItems(): \Rarus\Online\Kkt\Queue\DTO\ProductCollection
    {
        return $this->items;
    }

    /**
     * @param \Rarus\Online\Kkt\Queue\DTO\ProductCollection $items
     *
     * @return Document
     */
    protected function setItems(\Rarus\Online\Kkt\Queue\DTO\ProductCollection $items): Document
    {
        $this->items = $items;
        return $this;
    }
}
