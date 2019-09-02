<?php
/**
 * Структура описывает агентский платеж,
 * может использоваться в строке товаров или в шапке документа
 * Создается в клиентском коде
 * Признак агента по предмету расчёта (ограничен агентами, введенными в ККТ при фискализации).
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class AgentInfoPaymentAgentInfoType
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class AgentInfoPaymentAgentInfoType
{
    public function isPaymentAgentInfoType(?AgentInfoPaymentAgentInfoTypeValue $type)
    {
        if($type === null) {
            return '';
        }
        if($type->value() === AgentInfoPaymentAgentInfoTypeValue::PAYMENT_AGENT) {
            return AgentInfoPaymentAgentInfoTypeValue::PAYMENT_AGENT;
        }
        if($type->value() === AgentInfoPaymentAgentInfoTypeValue::PAYMENT_SUBAGENT) {
            return AgentInfoPaymentAgentInfoTypeValue::PAYMENT_SUBAGENT;
        }
        if($type->value() === AgentInfoPaymentAgentInfoTypeValue::BANK_AGENT) {
            return AgentInfoPaymentAgentInfoTypeValue::BANK_AGENT;
        }
        if($type->value() === AgentInfoPaymentAgentInfoTypeValue::BANK_SUBAGENT) {
            return AgentInfoPaymentAgentInfoTypeValue::BANK_SUBAGENT;
        }
        if($type->value() === AgentInfoPaymentAgentInfoTypeValue::ATTORNEY) {
            return AgentInfoPaymentAgentInfoTypeValue::ATTORNEY;
        }
        if($type->value() === AgentInfoPaymentAgentInfoTypeValue::COMISSION_AGENT) {
            return AgentInfoPaymentAgentInfoTypeValue::COMISSION_AGENT;
        }
        if($type->value() === AgentInfoPaymentAgentInfoTypeValue::OTHER) {
            return AgentInfoPaymentAgentInfoTypeValue::OTHER;
        }
    }
}
