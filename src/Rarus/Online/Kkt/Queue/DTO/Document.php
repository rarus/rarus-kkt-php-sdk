<?php
/**
 * Класс описывает DTO Объект документа
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
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
     * @var \Rarus\Online\Kkt\Queue\DTO\AgentInfo
     */
    protected $agentInfo;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\SupplierInfo
     */
    protected $supplierInfo;
    /**
     * @var string тег 1021
     */
    protected $cashier;
    /**
     * @var string тег 1192
     */
    protected $additionalCheckProps;
    /**
     * @var string тег 1227 Покупатель
     */
    protected $customerInfo;
    /**
     * @var string тег 1228 ИНН покупателя
     */
    protected $customerInn;
    /**
     * @var string наименование дополнительного реквизита пользователя
     */
    protected $nameAdditionalUserDetails;
    /**
     * @var string значение дополнительного реквизита пользователя
     */
    protected $valueAdditionalUserDetails;
    /**
     * @var float Кредит - example: 60.89
     */
    protected $credit;
    /**
     * @var float Аванс - example: 60.89
     */
    protected $advancePayment;
    /**
     * @var float Сумма наличными - example: 60.89
     */
    protected $cash;
    /**
     * @var float Сумма встречного представления - example: 60.89
     */
    protected $barter;
    /**
     * @var string tag_1125 признак расчета в интернет(0..1)
     */
    protected string $tag1125InternetPaymentSign;
    /**
     * @var string tag_1011 часовая зона места расчета (1..11)
     */
    protected string $tag1011TimeZonePlaceOfPayment;

    /**
     * @param string $externalId
     * @param string $docType
     * @param \DateTime $timestampUtc
     * @param \DateTime $timestampLocal
     * @param TaxInterface $taxSystem
     * @param User $user
     * @param string $callBackUri
     * @param string $inn
     * @param string $paymentAddress
     * @param Money $total
     * @param ProductCollection $items
     * @param AgentInfo $agentInfo
     * @param SupplierInfo $supplierInfo
     * @param string $cashier
     * @param string $additionalCheckProps
     * @param string $customerInfo
     * @param string $customerInn
     * @param string $nameAdditionalUserDetails
     * @param string $valueAdditionalUserDetails
     * @param Money $credit
     * @param Money $advancePayment
     * @param Money $cash
     * @param Money $barter
     * @param string $tag1125InternetPaymentSign
     * @param string $tag1011TimeZonePlaceOfPayment
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
        ProductCollection $items,
        AgentInfo $agentInfo,
        SupplierInfo $supplierInfo,
        string $cashier = '',
        string $additionalCheckProps = '',
        string $customerInfo = '',
        string $customerInn = '',
        string $nameAdditionalUserDetails = '',
        string $valueAdditionalUserDetails = '',
        Money $credit,
        Money $advancePayment,
        Money $cash,
        Money $barter,
        string $tag1125InternetPaymentSign = '',
        string $tag1011TimeZonePlaceOfPayment = '',
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
        $this->setAgentInfo($agentInfo);
        $this->setSupplierInfo($supplierInfo);
        $this->setCashier($cashier);
        $this->setAdditionalCheckProps($additionalCheckProps);
        $this->setCustomerInfo($customerInfo);
        $this->setCustomerInn($customerInn);
        $this->setNameAdditionalUserDetails($nameAdditionalUserDetails);
        $this->setValueAdditionalUserDetails($valueAdditionalUserDetails);
        $this->setCredit($credit);
        $this->setAdvancePayment($advancePayment);
        $this->setCash($cash);
        $this->setBarter($barter);
        $this->setTag1125InternetPaymentSign($tag1125InternetPaymentSign);
        $this->setTag1011TimeZonePlaceOfPayment($tag1011TimeZonePlaceOfPayment);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'                     => $this->getExternalId(),
            'doc_type'               => $this->getDocType(),
            'timestamp_utc'          => $this->getTimestampUtc()->getTimestamp(),
            'timestamp_local'        => $this->getTimestampLocal()->getTimestamp(),
            'email'                  => $this->getUser()->getEmail(),
            'phone'                  => $this->getUser()->getPhone(),
            'tax_system'             => $this->getTaxSystem()->getTaxCode(),
            'call_back_uri'          => $this->getCallBackUri(),
            'inn'                    => $this->getInn(),
            'payment_address'        => $this->getPaymentAddress(),
            'total'                  => $this->getTotal(),
            'agent_info'             => $this->getAgentInfo()->toArray(),
            'supplier_info'          => $this->getSupplierInfo()->toArray(),
            'cashier'                => $this->getCashier(),
            'additional_check_props' => $this->getAdditionalCheckProps(),
            'customer_info'          => $this->getCustomerInfo(),
            'customer_inn'           => $this->getCustomerInn(),
            'tag_1085'               => $this->getNameAdditionalUserDetails(),
            'tag_1086'               => $this->getValueAdditionalUserDetails(),
            'credit'                 => $this->getCredit(),
            'advance_payment'        => $this->getAdvancePayment(),
            'cash'                   => $this->getCash(),
            'barter'                 => $this->getBarter(),
            'tag_1125'               => (int)$this->getTag1125InternetPaymentSign(), //fix kkt-api issue typecast
            'tag_1011'               => (int)$this->getTag1011TimeZonePlaceOfPayment() //fix kkt-api issue typecast
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

    /**
     * @param mixed $agentInfo
     *
     * @return
     */
    public function setAgentInfo($agentInfo)
    {
        $this->agentInfo = $agentInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgentInfo(): AgentInfo
    {
        return $this->agentInfo;
    }

    /**
     * @param $supplierInfo
     *
     * @return $this
     */
    public function setSupplierInfo($supplierInfo)
    {
        $this->supplierInfo = $supplierInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSupplierInfo(): SupplierInfo
    {
        return $this->supplierInfo;
    }
    /**
     * @param $cashier
     *
     * @return $this
     */
    public function setCashier($cashier) : Document
    {
        $this->cashier = $cashier;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCashier()
    {
        return $this->cashier;
    }

    /**
     * @param $cashier
     *
     * @return $this
     */
    public function setAdditionalCheckProps($additionalCheckProps) : Document
    {
        $this->additionalCheckProps = $additionalCheckProps;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdditionalCheckProps()
    {
        return $this->additionalCheckProps;
    }

    /**
     * @param $customerInfo
     *
     * @return $this
     */
    public function setCustomerInfo ($customerInfo) : Document
    {
        $this->customerInfo = $customerInfo;
        return $this;
    }

    public function getCustomerInfo()
    {
        return $this->customerInfo;
    }

    /**
     * @param $customerInn
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Document
     */
    public function setCustomerInn ($customerInn) : Document
    {
        $this->customerInn = $customerInn;
        return $this;
    }

    public function getCustomerInn()
    {
        return $this->customerInn;
    }

    /**
     * @param $nameAdditionalUserDetails
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Document
     */
    public function setNameAdditionalUserDetails ($nameAdditionalUserDetails) : Document
    {
        $this->nameAdditionalUserDetails = $nameAdditionalUserDetails;
        return $this;
    }

    public function getNameAdditionalUserDetails()
    {
        return $this->nameAdditionalUserDetails;
    }

    /**
     * @param $valueAdditionalUserDetails
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Document
     */
    public function setValueAdditionalUserDetails ($valueAdditionalUserDetails) : Document
    {
        $this->valueAdditionalUserDetails = $valueAdditionalUserDetails;
        return $this;
    }

    public function getValueAdditionalUserDetails()
    {
        return $this->valueAdditionalUserDetails;
    }

    /**
     * @return float
     */
    public function getCredit() : float
    {
        return $this->credit;
    }

    /**
     * @param Money $credit
     *
     * @return Document
     */
    protected function setCredit(Money $credit): Document
    {
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        //todo Перенести format в toArray. Использовать Money. Преонбазовать в строку только перед отправкой на сервис
        $this->credit = (float)$moneyFormatter->format($credit);
        return $this;
    }

    /**
     * @return float
     */
    public function getAdvancePayment() : float
    {
        return $this->advancePayment;
    }

    /**
     * @param Money $advancePayment
     *
     * @return Document
     */
    protected function setAdvancePayment(Money $advancePayment): Document
    {
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        //todo Перенести format в toArray. Использовать Money. Преонбазовать в строку только перед отправкой на сервис
        $this->advancePayment = (float)$moneyFormatter->format($advancePayment);
        return $this;
    }

    /**
     * @return float
     */
    public function getCash() : float
    {
        return $this->cash;
    }

    /**
     * @param Money $cash
     *
     * @return Document
     */
    protected function setCash(Money $cash): Document
    {
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        //todo Перенести format в toArray. Использовать Money. Преонбазовать в строку только перед отправкой на сервис
        $this->cash = (float)$moneyFormatter->format($cash);
        return $this;
    }

    /**
     * @return float
     */
    public function getBarter() : float
    {
        return $this->barter;
    }

    /**
     * @param Money $barter
     *
     * @return Document
     */
    protected function setBarter(Money $barter): Document
    {
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        //todo Перенести format в toArray. Использовать Money. Преонбазовать в строку только перед отправкой на сервис
        $this->barter = (float)$moneyFormatter->format($barter);
        return $this;
    }

    public function getTag1125InternetPaymentSign(): string
    {
        return $this->tag1125InternetPaymentSign;
    }

    public function setTag1125InternetPaymentSign(string $tag1125InternetPaymentSign): void
    {
        $this->tag1125InternetPaymentSign = $tag1125InternetPaymentSign;
    }

    public function getTag1011TimeZonePlaceOfPayment(): string
    {
        return $this->tag1011TimeZonePlaceOfPayment;
    }

    public function setTag1011TimeZonePlaceOfPayment(string $tag1011TimeZonePlaceOfPayment): void
    {
        $this->tag1011TimeZonePlaceOfPayment = $tag1011TimeZonePlaceOfPayment;
    }
}
