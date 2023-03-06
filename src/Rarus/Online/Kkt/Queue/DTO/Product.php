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
    protected string $name;
    /**
     * @var Money цена за единицу товара
     */
    protected Money $price;
    /**
     * @var float количество приобретенного товара
     */
    protected float $quantity;
    /**
     * @var Money сумма товара
     */
    protected Money $sum;
    /**
     * @var string ставки НДС
     */
    protected string $tax;
    /**
     * @var Money цена за единицу товара
     */
    protected Money $taxSum;
    /**
     * @var string Признак способа расчета
     */
    protected string $signMethodCalculation;
    /**
     * @var string Признак предмета расчета
     */
    protected string $signCalculationObject;
    /**
     * @var string тег 1191 Пользовательские данные
     */
    protected string $userData;
    /**
     * @var string тег 1197 Единица измерения
     */
    protected string $measurementUnit;
    /**
     * @var string Тип маркировки
     */
    protected string $stampType;
    /**
     * @var string Глобальный идентификатор торговой единицы
     */
    protected string $gtin;
    /**
     * @var string Серийный номер
     */
    protected string $serialNumber;
    /**
     * @var string тег 1231 Номер таможенной декларации
     */
    protected string $customsDeclarationNumber;
    /**
     * @var AgentInfo
     */
    protected AgentInfo $agentInfo;
    /**
     * @var SupplierInfo
     */
    protected SupplierInfo $supplierInfo;

    /**
     * @var string|null
     * marking_code - string, код маркировки. Передаётся в явном формате с разделителями <0x1D>
     */
    protected ?string $markingCode;

    /**
     * @var int|null
     * planned_status - integer, планируемый статус товара. Значения:
     *      1 - Штучный товар, подлежащий обязательной маркировке средством идентификации, реализован
     *      2 - Мерный товар, подлежащий обязательной маркировке средством идентификации, в стадии реализации
     *      3 - Штучный товар, подлежащий обязательной маркировке средством идентификации, возвращен
     *      4 - Часть товара, подлежащего обязательной маркировке средством идентификации, возвращена
     */
    protected ?int $plannedStatus;

    /**
     * @var int|null
     * measure_quantity - integer, мера количества предмета расчета.
     * Значения: http://www.consultant.ru/document/cons_doc_LAW_362322/0060b1f1924347c03afbc57a8d4af63888f81c6c/
     * Примеры значений:
     * Килограмм = 11
     * Тонна = 12
     * Квадратный метр = 32
     * Сутки (день) = 70
     * Мегабайт = 81
     */
    protected ?int $measureQuantity;

    /**
     * Product constructor.
     *
     * @param string $name
     * @param Money $price
     * @param float $quantity
     * @param Money $sum
     * @param string $tax
     * @param Money $taxSum
     * @param string|null $signMethodCalculation
     * @param string|null $signCalculationObject
     * @param string|null $userData
     * @param string|null $measurementUnit
     * @param string|null $stampType
     * @param string|null $gtin
     * @param string|null $serialNumber
     * @param string|null $customsDeclarationNumber
     * @param AgentInfo $agentInfo
     * @param SupplierInfo $supplierInfo
     * @param string|null $markingCode
     * @param int|null $plannedStatus
     * @param int|null $measureQuantity
     */
    public function __construct(
        string $name,
        Money $price,
        float $quantity,
        Money $sum,
        string $tax,
        Money $taxSum,
        ?string $signMethodCalculation,
        ?string $signCalculationObject,
        ?string $userData,
        ?string $measurementUnit,
        ?string $stampType,
        ?string $gtin,
        ?string $serialNumber,
        ?string $customsDeclarationNumber,
        AgentInfo $agentInfo,
        SupplierInfo $supplierInfo,
        ?string $markingCode = null,
        ?int $plannedStatus = null,
        ?int $measureQuantity = null
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
        $this->setGtin($gtin);
        $this->setSerialNumber($serialNumber);
        $this->setCustomsDeclarationNumber($customsDeclarationNumber);
        $this->setAgentInfo($agentInfo);
        $this->setSupplierInfo($supplierInfo);
        $this->setMarkingCode($markingCode);
        $this->setPlannedStatus($plannedStatus);
        $this->setMeasureQuantity($measureQuantity);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $arResult = [
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
            'GTIN' => $this->getGtin(),
            'serial_number' => $this->getSerialNumber(),
            'customs_declaration' => $this->getCustomsDeclarationNumber(),
            'agent_info' => $this->getAgentInfo()->toArray(),
            'supplier_info' => $this->getSupplierInfo()->toArray(),
            'marking_code' => $this->getMarkingCode(),
            'planned_status' => $this->getPlannedStatus(),
            'measure_quantity' => $this->getMeasureQuantity()
        ];

        // удаляем из массива пустые значения тегов,
        // т.к. ферма не принимает null-значений и конвертирует их в '', 0, и пр. по своей внут.логике
        return array_filter($arResult);
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
     * @param Money $price
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
     * @param float $quantity
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
     * @param Money $sum
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
     * @param Money $taxSum
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
     * @param string|null $signMethodCalculation
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
     * @param string|null $signCalculationObject
     *
     * @return Product
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
     * @param string|null $userData
     *
     * @return Product
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
     * @param string|null $measurementUnit
     *
     * @return Product
     */
    protected function setMeasurementUnit(?string $measurementUnit): Product
    {
        if ($measurementUnit === null) {
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
     * @param string|null $stampType
     *
     * @return Product
     */
    protected function setStampType(?string $stampType): Product
    {
        if ($stampType === null) {
            $stampType = '';
        }
        $this->stampType = $stampType;
        return $this;
    }

    /**
     * @return string
     */
    public function getGtin(): string
    {
        return $this->gtin;
    }

    /**
     * @param string|null $gtin
     *
     * @return Product
     */
    protected function setGtin(?string $gtin): Product
    {
        if($gtin === null){
            $gtin = '';
        }
        $this->gtin = $gtin;
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
     * @param string|null $serialNumber
     *
     * @return Product
     */
    protected function setSerialNumber(?string $serialNumber): Product
    {
        if ($serialNumber === null) {
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
     * @param string|null $customsDeclarationNumber
     * @return Product
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
     * @return Product
     */
    public function setAgentInfo(AgentInfo $agentInfo): Product
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
     * @param SupplierInfo $supplierInfo
     *
     * @return Product
     */
    public function setSupplierInfo(SupplierInfo $supplierInfo): Product
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
     * @return string|null
     */
    public function getMarkingCode(): ?string
    {
        return $this->markingCode;
    }

    /**
     * @param string|null $markingCode
     * @return $this
     */
    protected function setMarkingCode(?string $markingCode): Product
    {

        $this->markingCode = $markingCode;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPlannedStatus(): ?int
    {
        return $this->plannedStatus;
    }

    /**
     * @param int|null $plannedStatus
     * @return $this
     */
    protected function setPlannedStatus(?int $plannedStatus): Product
    {
        $this->plannedStatus = $plannedStatus;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMeasureQuantity(): ?int
    {
        return $this->measureQuantity;
    }

    /**
     * @param int|null $measureQuantity
     * @return $this
     */
    protected function setMeasureQuantity(?int $measureQuantity): Product
    {
        $this->measureQuantity = $measureQuantity;
        return $this;
    }
}
