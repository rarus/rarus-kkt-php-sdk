<?php
/**
 * Структура описывает Атрибуты поставщика
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use \Rarus\Online\Kkt\Queue\DTO\Inn;

/**
 * Class SupplierInfo
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class SupplierInfo
{
    /**
     * @var string Наименование поставщика
     */
    protected $name;
    /**
     * @var string Телефон поставщика. Номер телефона не должен содержать спецсимволы, только +7{Цифры}
     */
    protected $phone;
    /**
     * @var string ИНН поставщика
     */
    protected $inn;

    /**
     * SupplierInfo constructor.
     *
     * @param string $name
     * @param string $phone
     * @param string $inn
     */
    public function __construct(
        string $name,
        string $phone,
        Inn $inn
    ) {
        $this->setName($name);
        $this->setPhone($phone);
        $this->setInn($inn);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'  => $this->getName(),
            'phone' => $this->getPhone(),
            'inn'   => $this->getInn()->getInn()
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
     * @return \Rarus\Online\Kkt\Queue\DTO\SupplierInfo
     */
    protected function setName(string $name): SupplierInfo
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\Телефон
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**+
     * @param $phone
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\SupplierInfo
     */
    protected function setPhone($phone): SupplierInfo
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\ИНН
     */
    public function getInn() : Inn
    {
        return $this->inn;
    }

    /**
     * @param $inn
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\SupplierInfo
     */
    protected function setInn(Inn $inn): SupplierInfo
    {
        $this->inn = $inn;
        return $this;
    }
}
