<?php
/**
 * Абстрактный класс транспорта.
 * Описывает общую структуру объекта Transport
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt;

use Psr\Log\LoggerInterface;
use Rarus\Online\Kkt\Service\DTO\Version;

/**
 * Class AbstractTransport
 *
 * @package Rarus\Online\Kkt
 */
abstract class AbstractTransport
{
    /**
     * @var Version
     */
    protected $version;
    /**
     * @var \Rarus\Online\Kkt\ApiClient
     */
    protected $apiClient;
    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * AbstractTransport constructor.
     *
     * @param \Rarus\Online\Kkt\ApiClient           $apiClient
     * @param \Rarus\Online\Kkt\Service\DTO\Version $version
     * @param \Psr\Log\LoggerInterface              $log
     */
    public function __construct(ApiClient $apiClient, Version $version, LoggerInterface $log)
    {
        $this->setApiClient($apiClient);
        $this->setVersion($version);
        $this->setLog($log);
    }

    /**
     * @return \Rarus\Online\Kkt\Service\DTO\Version
     */
    public function getVersion(): \Rarus\Online\Kkt\Service\DTO\Version
    {
        return $this->version;
    }

    /**
     * @param \Rarus\Online\Kkt\Service\DTO\Version $version
     */
    protected function setVersion(Version $version)
    {
        $this->version = $version;
    }

    /**
     * @return \Rarus\Online\Kkt\ApiClient
     */
    public function getApiClient(): \Rarus\Online\Kkt\ApiClient
    {
        return $this->apiClient;
    }

    /**
     * @param \Rarus\Online\Kkt\ApiClient $apiClient
     */
    protected function setApiClient(\Rarus\Online\Kkt\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLog(): \Psr\Log\LoggerInterface
    {
        return $this->log;
    }

    /**
     * @param \Psr\Log\LoggerInterface $log
     */
    protected function setLog(\Psr\Log\LoggerInterface $log)
    {
        $this->log = $log;
    }
}
