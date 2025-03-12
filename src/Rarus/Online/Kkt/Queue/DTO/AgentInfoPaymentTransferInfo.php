<?php
/**
 *Атрибуты оператора перевода денежных средств
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Money;
use Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoType;
use Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoTypeValue;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumber;
use Rarus\Online\Kkt\Queue\DTO\Inn;

/**
 * Class AgentInfoPaymentTransferInfo
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class AgentInfoPaymentTransferInfo
{
    /**
     * @var string Наименование оператора перевода
     */
    protected $name;
    /**
     * @var string Телефон оператора перевода. Номер телефона не должен содержать спецсимволы, только +7{Цифры}
     */
    protected $phone;
    /**
     * @var \libphonenumber\PhoneNumber|null Адрес оператора перевода
     */
    protected $address;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\Inn ИНН оператора перевода
     */
    protected $inn;

    /**
     * AgentInfoPaymentTransferInfo constructor.
     *
     * @param string                           $name
     * @param \libphonenumber\PhoneNumber|null $phone
     * @param string                           $address
     * @param \Rarus\Online\Kkt\Queue\DTO\Inn  $inn
     */
    public function __construct(
        string $name,
        ?PhoneNumber $phone,
        string $address,
        Inn $inn
    ) {
        $this->setName($name);
        $this->setPhone($phone);    
        $this->setAddress($address);
        $this->setInn($inn);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
        'name' => $this->getName(),
        'phone' => $this->getPhone(),
        'address' => $this->getAddress(),
        'inn' => $this->getInn()->getInn()
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentTransferInfo
     */
    protected function setName($name): AgentInfoPaymentTransferInfo
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param \libphonenumber\PhoneNumber|null $phone
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentTransferInfo
     */
    protected function setPhone(?PhoneNumber $phone): AgentInfoPaymentTransferInfo
    {
       $phoneUtil = PhoneNumberUtil::getInstance();
    	if ($phone !== null && $phoneUtil->isValidNumber($phone)) {
    		$this->phone = $phoneUtil->format($phone, PhoneNumberFormat::E164);
    	}
    	else {
    		$this->phone = '';
    	}
    	return $this;
    }


    /**
     * @return \libphonenumber\PhoneNumber|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $address
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentTransferInfo
     */
    protected function setAddress($address): AgentInfoPaymentTransferInfo
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\Inn
     */
    public function getInn()
    {
        return $this->inn;
    }

    /**
     * @param \Rarus\Online\Kkt\Queue\DTO\Inn $inn
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentTransferInfo
     */
    protected function setInn(Inn $inn): AgentInfoPaymentTransferInfo
    {    	
        $this->inn = $inn;    	
        return $this;
    }
}
