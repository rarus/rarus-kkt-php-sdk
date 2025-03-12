<?php
/**
 * Структура описывает агентский платеж,
 * может использоваться в строке товаров или в шапке документа
 * Создается в клиентском коде
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Money;
use Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoType;
use Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoTypeValue;
use Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentTransferInfo;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumber;

/**
 * Class AgentInfo
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class AgentInfo
{
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoTypeValue|null, Признак агента по предмету расчёта
     */
    protected $type;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgent  Атрибуты плаатежного агента
     */
    protected $paymentAgentInfo;
    /**
     * @var \libphonenumber\PhoneNumber|null Телефон оператора приема платежей.
     */
    protected $phoneNumber;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentTransferInfo Атрибуты оператора перевода денежных средств
     */
    protected $paymentTransferInfo;

    /**
     * AgentInfo constructor.
     *
     * @param \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoTypeValue|null $type
     * @param \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgent                   $paymentAgentInfo
     * @param \libphonenumber\PhoneNumber|null                                    $phoneNumber
     * @param \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentTransferInfo            $paymentTransferInfo
     */
    public function __construct(
        ?AgentInfoPaymentAgentInfoTypeValue $type,
        AgentInfoPaymentAgent $paymentAgentInfo,
        ?PhoneNumber $phoneNumber,
        AgentInfoPaymentTransferInfo $paymentTransferInfo
    ) {
        $this->setType($type);
        $this->setPaymentAgentInfo($paymentAgentInfo);
        $this->setPhoneNumber($phoneNumber);
        $this->setPaymentTransferInfo($paymentTransferInfo);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'payment_agent_info' => $this->getPaymentAgentInfo()->toArray(),
            'payment_acceptor_info' => [
                'phone' => $this->getPhoneNumber()
            ],
            'payment_transfer_info' => $this->getPaymentTransferInfo()->toArray()
        ];
    }
    
    public function getType(): ?AgentInfoPaymentAgentInfoTypeValue
    {
        return $this->type;
    }

    /**
     * @param \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoTypeValue|null $type
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfo
     */
    protected function setType(?AgentInfoPaymentAgentInfoTypeValue $type): AgentInfo
    {
        if ($type === null) {
            $type = '';
        } else {
            $AgentInfoPaymentAgentInfoType = new AgentInfoPaymentAgentInfoType();
            $type = $AgentInfoPaymentAgentInfoType->isPaymentAgentInfoType($type);
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgent
     */
    public function getPaymentAgentInfo(): AgentInfoPaymentAgent
    {
        return $this->paymentAgentInfo;
    }

    /**
     * @param \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgent|null $paymentAgentInfo
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfo
     */
    protected function setPaymentAgentInfo(?AgentInfoPaymentAgent $paymentAgentInfo): AgentInfo
    {
        $this->paymentAgentInfo = $paymentAgentInfo;
        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param \libphonenumber\PhoneNumber|null $phoneNumber
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfo
     */
    protected function setPhoneNumber(?PhoneNumber $phoneNumber): AgentInfo
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        if ($phoneNumber !== null && $phoneUtil->isValidNumber($phoneNumber)) {
            $this->phoneNumber = $phoneUtil->format($phoneNumber, PhoneNumberFormat::E164);
        }
        else {
            $this->phoneNumber = '';
        }
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentTransferInfo
     */
    public function getPaymentTransferInfo()
    {
        return $this->paymentTransferInfo;
    }

    /**
     * @param $paymentTransferInfo
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfo
     */
    protected function setPaymentTransferInfo($paymentTransferInfo): AgentInfo
    {
        $this->paymentTransferInfo = $paymentTransferInfo;
        return $this;
    }
}
