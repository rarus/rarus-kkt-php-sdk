<?php
/**
 * Класс описывает DTO объект передаваемый для получения статуса операции
 * Принимает к конструктор передается 2 DTO объекта OperationState и Fiscalisation
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

/**
 * Class OperationStatus
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class OperationStatus
{
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\OperationState
     */
    protected $operationState;
    /**
     * @var \Rarus\Online\Kkt\Queue\DTO\Fiscalisation
     */
    protected $fiscalisation;

    /**
     * OperationStatus constructor.
     *
     * @param \Rarus\Online\Kkt\Queue\DTO\OperationState $operationState
     * @param \Rarus\Online\Kkt\Queue\DTO\Fiscalisation  $fiscalisation
     */
    public function __construct(OperationState $operationState, Fiscalisation $fiscalisation)
    {
        $this->setOperationState($operationState);
        $this->setFiscalisation($fiscalisation);
    }

    /**
     * @param \Rarus\Online\Kkt\Queue\DTO\OperationState $operationState
     *
     * @return OperationStatus
     */
    public function setOperationState(OperationState $operationState): OperationStatus
    {
        $this->operationState = $operationState;
        return $this;
    }

    /**
     * @param mixed $fiscalisation
     *
     * @return OperationStatus
     */
    public function setFiscalisation($fiscalisation)
    {
        $this->fiscalisation = $fiscalisation;
        return $this;
    }

    /**
     * @return \Rarus\Online\Kkt\Queue\DTO\OperationState
     */
    public function getOperationState(): OperationState
    {
        return $this->operationState;
    }

    /**
     * @return mixed
     */
    public function getFiscalisation(): Fiscalisation
    {
        return $this->fiscalisation;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return[
            'operation_state' => $this->getOperationState()->toArray(),
            'fiscalisation' => $this->getFiscalisation()->toArray()
        ];
    }
}
