<?php
/**
 * Класс описывает транспорт для
 * сервисных запросов, для взаимодействия с ККТ
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue;

use Rarus\Online\Kkt\{
    ApiClient,
    AbstractTransport,
    Service\DTO\Version,
    Service\DTO\VersionCollection
};
use Psr\Log\LoggerInterface;
use Rarus\Online\Kkt\Queue\DTO\{
    ZReports,
    Document,
    Fiscalisation,
    OperationState,
    OperationStatus,
    ProductCollection,
    ZReportCollection
};
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Money\Exception\ParserException;
use Money\Formatter\DecimalMoneyFormatter;

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
     * @param \Rarus\Online\Kkt\ApiClient           $apiClient
     * @param \Rarus\Online\Kkt\Service\DTO\Version $version
     * @param \Psr\Log\LoggerInterface              $log
     */
    public function __construct(
        ApiClient $apiClient,
        Version $version,
        LoggerInterface $log
    ) {
        parent::__construct($apiClient, $version, $log);
    }


    /**
     * Метод получает список z-отчетов за период,
     * которые были сформированы фермой ККТ с указанным идентификатором api_key
     *
     * @param \DateTime $from - Начало периода формирования отчета
     * @param \DateTime $to   - Конец периода формирования отчета
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\ZReportCollection
     */
    public function getZReports(\DateTime $from, \DateTime $to): ZReportCollection
    {
        $this->log->info(
            'rarus.online.kkt.Queue.Transport.' . __FUNCTION__ . '.start',
            [
                'from' => $from->format(\DateTime::ATOM),
                'to'   => \DateTime::ATOM
            ]
        );

        $zReports = $this->makeRequest(
            \sprintf(
                'reports/z?from=%s&to=%s',
                (string)$from->getTimestamp(),
                (string)$to->getTimestamp()
            ),
            'get',
            [
                (string)$from->getTimestamp(),
                (string)$to->getTimestamp()
            ]
        );

        $zReportsCollection = new ZReportCollection();

        if (\count($zReports) > 0) {
            foreach ((array)$zReports as $zReport) {
                $zReportDto = new ZReports(
                    (new \DateTime())->setTimestamp($zReport['timestamp_uts']),
                    (int)$zReport['fiscal_shift_num'],
                    (int)$zReport['fiscal_doc_num']
                );

                $zReportsCollection->attach($zReportDto, $zReport);
            }
        }

        $this->log->info('rarus.online.kkt.Queue.Transport.' . __FUNCTION__ . '.finish');

        return $zReportsCollection;
    }

    private function makeRequest(string $apiMethod, string $method, array $args = []): array
    {
        return $this->apiClient->executeApiRequest(
            $this->version->getBaseUrl() . '/' . $apiMethod,
            $method,
            $args
        );
    }

    /**
     * Метод выполняет отправку документа в соответствующую очередь для последующей передачи на ККТ. Очередь
     * определяется по api-key передаваемом в заголовке запроса. Параметр api_key выдается при регистрации магазина,
     * юрлица и ККТ в сервисе.
     *
     * @param \Rarus\Online\Kkt\Queue\DTO\Document $document
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\OperationState
     */
    public function addDocument(Document $document): OperationState
    {
        $this->log->info('rarus.online.kkt.Queue.Transport.' . __FUNCTION__ . '.start');

        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $items = [];

        foreach ($document->getItems() as $key => $product) {
            $items['items'][] = $product->toArray();

            $items['items'][$key]['price'] = (float)$moneyFormatter->format($items['items'][$key]['price']);
            $items['items'][$key]['sum'] = (float)$moneyFormatter->format($items['items'][$key]['sum']);
            $items['items'][$key]['tax_sum'] = (float)$moneyFormatter->format($items['items'][$key]['tax_sum']);
        }

        $documentArray = \array_merge($document->toArray(), $items);


        // Получаем текущее значение serialize_precision из php.ini
        $serializePrecision = \ini_get('serialize_precision');

        $documentArray['total'] = (float)$moneyFormatter->format($documentArray['total']);

        // Устанавливаем значение serialize_precision в -1.
        // TODO на данный момент есть баг с преобразованием float в json_encode,
        // TODO хотя пишут что Status: Closed https://bugs.php.net/bug.php?id=72567
        \ini_set('serialize_precision', '-1');

        $body = \json_encode($documentArray, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE);

        // Устанавливаем обратно значение serialize_precision
        \ini_set('serialize_precision', $serializePrecision);


        $this->log->info('rarus.online.kkt.Queue.Transport.' . __FUNCTION__ . '.', ['body' => $body]);


        $documentResult = $this->makeRequest(
            'document',
            'post',
            [
                'body' => $body
            ]
        );

        $this->log->info('rarus.online.kkt.Queue.Transport.' . __FUNCTION__ . '.finish');

        return new OperationState(
            (string)$documentResult['operation']['operation_id'],
            (string)$documentResult['operation']['timestamp_utc'],
            (string)$documentResult['operation']['status'],
            (string)$documentResult['operation']['message']
        );
    }

    /**
     * Метод выполняет выполняет запрос о состоянии операции в очереди сервиса
     *
     * @param \Rarus\Online\Kkt\Queue\DTO\OperationState $operationState
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\OperationStatus
     * @throws \Money\Exception\ParserException
     */
    public function getDocumentOperationStatusByOperationId(OperationState $operationState): OperationStatus
    {
        $this->log->info('rarus.online.kkt.Queue.Transport.' . __FUNCTION__ . '.start');

        $documentState = $this->makeRequest(
            \sprintf(
                'document/%s',
                $operationState->getExternalOperationId()
            ),
            'get',
            [
                $operationState->getExternalOperationId()
            ]
        );

        $operationStateResponse = new OperationState(
            (string)$documentState['operation']['operation_id'],
            (string)$documentState['operation']['timestamp_utc'],
            (string)$documentState['operation']['status'],
            (string)$documentState['operation']['message']
        );


        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        $total = $moneyParser->parse((string)$documentState['fiscalization']['total'], 'RUB');

        $fiscalisation = new Fiscalisation(
            $total,
            (int)$documentState['fiscalization']['fiscal_number'],
            (int)$documentState['fiscalization']['shift_fiscal_number'],
            (string)$documentState['fiscalization']['receipt_date'],
            (string)$documentState['fiscalization']['fn_number'],
            (string)$documentState['fiscalization']['kkt_registration_number'],
            (int)$documentState['fiscalization']['fiscal_attribute'],
            (int)$documentState['fiscalization']['fiscal_doc_number'],
            (string)$documentState['fiscalization']['fns_site']
        );

        $this->log->info('rarus.online.kkt.Queue.Transport.' . __FUNCTION__ . '.finish');

        return new OperationStatus($operationStateResponse, $fiscalisation);
    }
}
