<?php
/**
 * Класс описывает транспорт для
 * сервисных запросов, не требующие авторизации
 *
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Service;

use Psr\Log\LoggerInterface;
use Rarus\Online\Kkt\AbstractTransport;
use Rarus\Online\Kkt\ApiClient;
use Rarus\Online\Kkt\Queue\DTO\Document;
use Rarus\Online\Kkt\Queue\DTO\OperationStatus;
use Rarus\Online\Kkt\Service\DTO\Version;
use Rarus\Online\Kkt\Queue\DTO\OperationState;
use Rarus\Online\Kkt\Service\DTO\Ping;
use Rarus\Online\Kkt\Service\DTO\VersionCollection;

/**
 * Class Transport
 *
 * @package Rarus\Online\Kkt\Queue
 */
class Transport extends AbstractTransport
{
    /**
     * Transport constructor.
     *
     * @param \Rarus\Online\Kkt\ApiClient $apiClient
     * @param \Psr\Log\LoggerInterface    $log
     */
    public function __construct(
        ApiClient $apiClient,
        LoggerInterface $log
    ) {
        $this->setApiClient($apiClient);
        $this->setLog($log);
    }

    /**
     * Получение списка версий протокола
     *
     * @param string $apiMethod - наименование api метода в сервисе.
     * @param string $method    - http метод; get либо post
     *
     * @return \Rarus\Online\Kkt\Service\DTO\VersionCollection
     */
    public function getVersions(string $apiMethod, string $method): VersionCollection
    {
        $this->log->info('rarus.online.kkt.Service.Transport.' . __FUNCTION__ . '.start');

        $versionsResult = $this->makeRequest($apiMethod, $method);

        $versionCollection = new VersionCollection();

        foreach ($versionsResult as $version) {
            $newVersion = new Version($version['version'], $version['base_url'], $version['stable']);
            $versionCollection->attach($newVersion, $version);
        }

        $this->log->info('rarus.online.kkt.Service.Transport.' . __FUNCTION__ . '.finish');

        //return new Version($versionsResult['version'], $versionsResult['base_url'], $versionsResult['stable']);
        return $versionCollection;
    }


    private function makeRequest(string $apiMethod, string $method): array
    {
        return $this->apiClient->executeApiRequest(
            $apiMethod,
            $method
        );
    }

    /**
     * Пинг сервиса
     *
     * @return \Rarus\Online\Kkt\Service\DTO\Ping
     */
    public function ping(): Ping
    {
        $this->log->info('rarus.online.kkt.Service.Transport.' . __FUNCTION__ . '.start');
        $pingResult = $this->makeRequest('ping', 'get');
        $this->log->info('rarus.online.kkt.Service.Transport.' . __FUNCTION__ . '.finish');

        return new Ping($pingResult['message']);
    }
}
