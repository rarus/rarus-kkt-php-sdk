<?php
/**
 * Класс описывает DTO объект User
 * Пользователь в чеке
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

/**
 * Class User
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class User
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string телефон пользователя
     */
    protected $phone;
    /**
     * @var string e-mail пользовалеля
     */
    protected $email;

    /**
     * User constructor.
     *
     * @param int    $id
     * @param string $phone
     * @param string $email
     */
    public function __construct(int $id, string $phone, string $email)
    {
        $this->setId($id);
        $this->setPhone($phone);
        $this->setEmail($email);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'    => $this->getId(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone()
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    protected function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    protected function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    protected function setPhone(string $phone)
    {
        $this->phone = $phone;
    }
}
