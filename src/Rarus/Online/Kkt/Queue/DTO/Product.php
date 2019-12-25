<?php
/**
 * Класс описывает DTO объект товара
 * Создается в клиентском коде
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Money;

/**
 * Class Product
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class Product
{
    /**
     * @var string наименование товара
     */
    protected $name;
    /**
     * @var Money цена за единицу товара
     */
    protected $price;
    /**
     * @var float количество приобретенного товара
     */
    protected $quantity;
    /**
     * @var Money сумма товара
     */
    protected $sum;
    /**
     * @var string ставки НДС
     */
    protected $tax;
    /**
     * @var Money цена за единицу товара
     */
    protected $taxSum;

    /**
     * @var string Признак способа расчета
     */
    protected $signMethodCalculation;
    /**
     * @var string Признак предмета расчета
     */
    protected $signCalculationObject;
    /**
     * @var string тег 1191 Пользовательские данные
     */
    protected $userData;
    /**
     * @var string тег 1197 Единица измерения
     */
    protected $measurementUnit;
    /**
     * @var string Тип маркировки
     */
    protected $stampType;
    /**
     * @var string Глобальный идентификатор торговой единицы
     */
    protected $globalTradeUnitIdentifier;
    /**
     * @var string Серийный номер
     */
    protected $serialNumber;
    /**
     * @var string тег 1231 Номер таможенной декларации
     */
    protected $customsDeclarationNumber;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\AgentInfo
     */
    protected $agentInfo;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\SupplierInfo
     */
    protected $supplierInfo;
     /**
     * Product constructor.
     *
     * @param string                                   $name
     * @param \Money\Money                             $price
     * @param float                                    $quantity
     * @param \Money\Money                             $sum
     * @param string                                   $tax
     * @param \Money\Money                             $taxSum
     * @param string                                   $signMethodCalculation
     * @param string                                   $signCalculationObject
     * @param string                                   $userData
     * @param string                                   $measurementUnit
     * @param string                                   $stampType
     * @param string                                   $globalTradeUnitIdentifier
     * @param string                                   $serialNumber
     * @param string                                   $customsDeclarationNumber
     * @param \Rarus\Online\Kkt\Queue\DTO\AgentInfo    $agentInfo
     * @param \Rarus\Online\Kkt\Queue\DTO\SupplierInfo $supplierInfo
     */
    public function __construct(
        string $name,
        Money $price,
        float $quantity,
        Money $sum,
        string $tax,
        Money $taxSum,
        ?string $signMethodCalculation = '',
        ?string $signCalculationObject = '',
        ?string $userData = '',
        ?string $measurementUnit = '',
        ?string $stampType = '',
        ?string $globalTradeUnitIdentifier = '',
        ?string $serialNumber = '',
        ?string $customsDeclarationNumber  = '',
        AgentInfo $agentInfo,
        SupplierInfo $supplierInfo
    ) {
        $this->setName($name);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setSum($sum);
        $this->setTax($tax);
        $this->setTaxSum($taxSum);
        $this->setSignMethodCalculation($signMethodCalculation);
        $this->setSignCalculationObject($signCalculationObject);
        $this->setUserData($userData);
        $this->setMeasurementUnit($measurementUnit);
        $this->setStampType($stampType);
        $this->setGlobalTradeUnitIdentifier($globalTradeUnitIdentifier);
        $this->setSerialNumber($serialNumber);
        $this->setCustomsDeclarationNumber($customsDeclarationNumber);
        $this->setAgentInfo($agentInfo);
        $this->setSupplierInfo($supplierInfo);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'     => $this->getName(),
            'price'    => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'sum'      => $this->getSum(),
            'tax'      => $this->getTax(),
            'tax_sum'  => $this->getTaxSum(),
            'sign_method_calculation' => $this->getSignMethodCalculation(),
            'sign_calculation_object' => $this->getSignCalculationObject(),
            'user_data' => $this->getUserData(),
            'measurement_unit' => $this->getMeasurementUnit(),
            'stamp_type' => $this->getStampType(),
            'GTIN' => $this->getGlobalTradeUnitIdentifier(),
            'serial_number' => $this->getSerialNumber(),
            'customs_declaration' => $this->getCustomsDeclarationNumber(),
            'agent_info' => $this->getAgentInfo()->toArray(),
            'supplier_info' => $this->getSupplierInfo()->toArray()
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Product
     */
    protected function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @param \Money\Money $price
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setPrice(Money $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return Product
     */
    protected function setQuantity(float $quantity): Product
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return Money
     */
    public function getSum(): Money
    {
        return $this->sum;
    }

    /**
     * @param \Money\Money $sum
     *
     * @return Product
     */
    protected function setSum(Money $sum): Product
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * @return string
     */
    public function getTax(): string
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     *
     * @return Product
     */
    protected function setTax(string $tax): Product
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return Money
     */
    public function getTaxSum(): Money
    {
        return $this->taxSum;
    }

    /**
     * @param \Money\Money $taxSum
     *
     * @return Product
     */
    protected function setTaxSum(Money $taxSum): Product
    {
        $this->taxSum = $taxSum;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignMethodCalculation(): string
    {
        return $this->signMethodCalculation;
    }

    /**
     * @param string $signMethodCalculation
     *
     * @return Product
     */
    protected function setSignMethodCalculation(?string $signMethodCalculation): Product
    {
        if($signMethodCalculation === null){
            $signMethodCalculation = '';
        }
        $this->signMethodCalculation = $signMethodCalculation;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignCalculationObject(): string
    {
        return $this->signCalculationObject;
    }

    /**
     * @param string $signCalculationObject
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setSignCalculationObject(?string $signCalculationObject): Product
    {
        if($signCalculationObject === null){
            $signCalculationObject = '';
        }
        $this->signCalculationObject = $signCalculationObject;
        return $this;
    }
    /**
     * @return string
     */
    public function getUserData(): string
    {
        return $this->userData;
    }

    /**
     * @param string $userData
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setUserData(?string $userData): Product
    {
        if($userData === null){
            $userData = '';
        }
        $this->userData = $userData;
        return $this;
    }

    /**
     * @return string
     */
    public function getMeasurementUnit(): string
    {
        return $this->measurementUnit;
    }

    /**
     * @param string $measurementUnit
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setMeasurementUnit(?string $measurementUnit): Product
    {
        if($measurementUnit === null){
            $measurementUnit = '';
        }
        $this->measurementUnit = $measurementUnit;
        return $this;
    }

    /**
     * @return string
     */
    public function getStampType(): string
    {
        return $this->stampType;
    }

    /**
     * @param string $stampType
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setStampType(?string $stampType): Product
    {
        if($stampType === null){
            $stampType = '';
        }
        $this->stampType = $stampType;
        return $this;
    }

    /**
     * @return string
     */
    public function getGlobalTradeUnitIdentifier(): string
    {
        return $this->globalTradeUnitIdentifier;
    }

    /**
     * @param string $globalTradeUnitIdentifier
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setGlobalTradeUnitIdentifier(?string $globalTradeUnitIdentifier): Product
    {
        if($globalTradeUnitIdentifier === null){
            $globalTradeUnitIdentifier = '';
        }
        $this->globalTradeUnitIdentifier = $globalTradeUnitIdentifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setSerialNumber(?string $serialNumber): Product
    {
        if($serialNumber === null){
            $serialNumber = '';
        }
        $this->serialNumber = $serialNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomsDeclarationNumber(): string
    {
        return $this->customsDeclarationNumber;
    }

    /**
     * @param string $stampType
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Product
     */
    protected function setCustomsDeclarationNumber(?string $customsDeclarationNumber): Product
    {
        if($customsDeclarationNumber === null){
            $customsDeclarationNumber = '';
        }
        $this->customsDeclarationNumber = $customsDeclarationNumber;
        return $this;
    }

    /**
     * @param mixed $agentInfo
     *
     * @return
     */
    public function setAgentInfo(AgentInfo $agentInfo)
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
    public function setSupplierInfo(SupplierInfo $supplierInfo)
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

}
