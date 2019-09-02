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
 * Class AgentInfoPaymentAgentInfoTypeValue
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
final class AgentInfoPaymentAgentInfoTypeValue  extends AbstractEnumeration
{
    const PAYMENT_AGENT = 'payment_agent';
    const PAYMENT_SUBAGENT = 'payment_subagent';
    const BANK_AGENT = 'bank_agent';
    const BANK_SUBAGENT = 'bank_subagent';
    const ATTORNEY = 'attorney';
    const COMISSION_AGENT = 'comission_agent';
    const OTHER = 'other';
}
