<?php
/**
 * Класс описывает DTO объект "состояние документа"
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

/**
 * Class OperationState
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class OperationState
{
    /**
     * @var string внешний id операции
     */
    protected $externalOperationId;
    /**
     * @var string //todo \DateTime
     */
    protected $timestampUtc;
    /**
     * @var string название статуса
     */
    protected $status;
    /**
     * @var string сообщение статуса
     */
    protected $message;

    /**
     * OperationState constructor.
     *
     * @param string $externalOperationId
     * @param string $timestampUtc
     * @param string $status
     * @param string $message
     */
    public function __construct(string $externalOperationId, string $timestampUtc, string $status, string $message)
    {
        $this->setExternalOperationId($externalOperationId);
        $this->setTimestampUtc($timestampUtc);
        $this->setStatus($status);
        $this->setMessage($message);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'external_id'   => $this->getExternalOperationId(),
            'timestamp_uts' => $this->getTimestampUtc(),
            'status'        => $this->getStatus(),
            'message'       => $this->getMessage()
        ];
    }

    /**
     * @return string
     */
    public function getExternalOperationId(): string
    {
        return $this->externalOperationId;
    }

    /**
     * @param string $externalOperationId
     *
     * @return OperationState
     */
    public function setExternalOperationId(string $externalOperationId): OperationState
    {
        $this->externalOperationId = $externalOperationId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestampUtc(): string//todo \DateTime
    {
        return $this->timestampUtc;
    }

    /**
     * @param string $timestampUtc
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\OperationState
     */
    public function setTimestampUtc(string $timestampUtc): OperationState //todo \DateTime
    {
        $this->timestampUtc = $timestampUtc;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return OperationState
     */
    public function setStatus(string $status): OperationState
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return OperationState
     */
    public function setMessage(string $message): OperationState
    {
        $this->message = $message;
        return $this;
    }
}
