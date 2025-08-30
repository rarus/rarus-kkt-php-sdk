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
        $result = '';
            
        if ($type === null) {
            return $result;
        } 
        if ($type->value() === AgentInfoPaymentAgentInfoTypeValue::PAYMENT_AGENT) {
            $result = AgentInfoPaymentAgentInfoTypeValue::PAYMENT_AGENT;
        }
        if ($type->value() === AgentInfoPaymentAgentInfoTypeValue::PAYMENT_SUBAGENT) {
            $result = AgentInfoPaymentAgentInfoTypeValue::PAYMENT_SUBAGENT;
        }
        if ($type->value() === AgentInfoPaymentAgentInfoTypeValue::BANK_AGENT) {
            $result = AgentInfoPaymentAgentInfoTypeValue::BANK_AGENT;
        }
        if ($type->value() === AgentInfoPaymentAgentInfoTypeValue::BANK_SUBAGENT) {
            $result = AgentInfoPaymentAgentInfoTypeValue::BANK_SUBAGENT;
        }
        if ($type->value() === AgentInfoPaymentAgentInfoTypeValue::ATTORNEY) {
            $result = AgentInfoPaymentAgentInfoTypeValue::ATTORNEY;
        }
        if ($type->value() === AgentInfoPaymentAgentInfoTypeValue::COMISSION_AGENT) {
            $result = AgentInfoPaymentAgentInfoTypeValue::COMISSION_AGENT;
        }
        if ($type->value() === AgentInfoPaymentAgentInfoTypeValue::OTHER) {
            $result = AgentInfoPaymentAgentInfoTypeValue::OTHER;
        }
        
        return $result;
    }
}
