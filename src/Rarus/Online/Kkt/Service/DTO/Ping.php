<?php
/**
 * Класс описывает DTO объект сущности ping -Пинг сервиса.
 * сервиса онлайн касс.
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Service\DTO;

/**
 * Class Ping
 *
 * @package Rarus\Online\Kkt\Service\DTO
 */
class Ping
{
    /**
     * @var string сообщение об успешной операции
     */
    protected $message;

    /**
     * Ping constructor.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->setMessage($message);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message' => $this->getMessage()
        ];
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
     */
    protected function setMessage(string $message)
    {
        $this->message = $message;
    }
}
