<?php
/**
 * Атрибуты плаатежного агента - Наименование операции(макс. длина 24 символа)
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Rarus\Online\Kkt\Exception\RarusKktException;

/**
 * Class AgentInfoPaymentAgentInfoOperation
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class AgentInfoPaymentAgentInfoOperation
{
    const MAX_LENGTH = 24;
    /**
     * @var string Наименование операции(макс. длина 24 символа)
     */
    protected $operation;

    /**
     * AgentInfoPaymentAgentInfoOperation constructor.
     *
     * @param string $operation
     */
    public function __construct(
        ?string $operation
    ) {
        $this->setOperation($operation);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'operation' => $this->getOperation()
        ];
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param $operation
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoOperation
     */
    protected function setOperation(?string $operation): AgentInfoPaymentAgentInfoOperation
    {
        if (empty($operation) || $operation === null) {
            $operation = '';
        }
        if (strlen($operation) > self::MAX_LENGTH) {
            $operation = substr($operation, 0, self::MAX_LENGTH);
        }
        $this->operation = $operation;
        return $this;
    }
}
