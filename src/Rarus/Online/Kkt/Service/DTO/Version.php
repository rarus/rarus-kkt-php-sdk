<?php
/**
 * Класс описывает DTO объект сущности versions - Получение списка версий протокола
 * сервиса онлайн касс.
 *
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Service\DTO;

/**
 * Class Version
 *
 * @package Rarus\Online\Kkt\Service\DTO
 */
class Version
{
    /**
     * @var string номер версии
     */
    protected $version;
    /**
     * @var string базовый url
     */
    protected $baseUrl;
    /**
     * @var bool стальная \ не стабильная версия
     */
    protected $isStable;

    /**
     * Version constructor.
     *
     * @param string $version
     * @param string $baseUrl
     * @param bool   $isStable
     */
    public function __construct(string $version, string $baseUrl, bool $isStable)
    {
        $this->setVersion($version);
        $this->setBaseUrl($baseUrl);
        $this->setIsStable($isStable);
    }

    /**
     * @param bool $isStable
     */
    protected function setIsStable(bool $isStable)
    {
        $this->isStable = $isStable;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'version'  => $this->getVersion(),
            'base_url' => $this->getBaseUrl(),
            'stable'   => $this->isIsStable()
        ];
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    protected function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    protected function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return bool
     */
    public function isIsStable(): bool
    {
        return $this->isStable;
    }
}
