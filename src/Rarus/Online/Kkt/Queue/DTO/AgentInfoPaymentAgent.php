<?php
/**
 * Атрибуты плаатежного агента
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use \libphonenumber\PhoneNumberUtil;
use \libphonenumber\PhoneNumberFormat;
use \libphonenumber\PhoneNumber;
use Rarus\Online\Kkt\Exception\RarusKktException;

/**
 * Class AgentInfoPaymentAgent
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class AgentInfoPaymentAgent
{
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoOperation Наименование операции(макс. длина 24 символа)
     */
    protected $operation;
    /**
     * @var \libphonenumber\PhoneNumber|null  Телефон платежного агента.
     */
    protected $phone;

    /**
     * AgentInfoPaymentAgent constructor.
     *
     * @param \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoOperation $operation
     * @param \libphonenumber\PhoneNumber|null                               $phone
     */
    public function __construct(
        AgentInfoPaymentAgentInfoOperation $operation,
        ?PhoneNumber $phone
    ) {
        $this->setOperation($operation);
        $this->setPhone($phone);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'operation'  => $this->getOperation(),
            'phone' => $this->getPhone()
        ];
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoOperation
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param  $operation
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgent
     */
    protected function setOperation(AgentInfoPaymentAgentInfoOperation $operation): AgentInfoPaymentAgent
    {
        $this->operation = $operation->getOperation();
        return $this;
    }

    /**
     * @return \libphonenumber\PhoneNumber|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgent|null
     */
    protected function setPhone($phone): ?AgentInfoPaymentAgent
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
}
