<?php
declare(strict_types=1);

namespace Rarus\Online\Kkt;

use Psr\Log\{
    NullLogger,
    LoggerInterface
};

use Fig\Http\Message\StatusCodeInterface as StatusCode;

use GuzzleHttp\{
    ClientInterface,
    Exception\BadResponseException,
    Exception\ClientException,
    Exception\GuzzleException,
    HandlerStack
};

/**
 * Class ApiClient
 *
 * @package Rarus\Online\Kkt
 */
class ApiClient
{
    /**
     * @var string SDK version
     */
    const SDK_VERSION = '2.1.1';

    /**
     * @var string user agent
     */
    const API_USER_AGENT = 'rarus-kkt-php-sdk';

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * @var HandlerStack
     */
    protected $guzzleHandlerStack;

    /**
     * @var string
     */
    protected $apiEndpoint;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var float
     */
    protected $connectTimeout;

    /**
     * ApiClient constructor.
     *
     * @param string                        $apiEndpointUrl
     * @param string                        $apiKey
     * @param \GuzzleHttp\ClientInterface   $obHttpClient
     * @param \Psr\Log\LoggerInterface|null $obLogger
     */
    public function __construct(
        string $apiEndpointUrl,
        string $apiKey,
        ClientInterface $obHttpClient,
        LoggerInterface $obLogger = null
    ) {
        $this->apiEndpoint = $apiEndpointUrl;
        $this->httpClient = $obHttpClient;
        $this->apiKey = $apiKey;

        if ($obLogger !== null) {
            $this->log = $obLogger;
        } else {
            $this->log = new NullLogger();
        }
        $this->guzzleHandlerStack = HandlerStack::create();
        $this->setConnectTimeout(2);

        $this->log->debug(
            'rarus.online.kkt.apiClient.init',
            [
                'url'     => $apiEndpointUrl,
                'api-key' => $this->getApiKey()
            ]
        );
    }

    /**
     * @return string
     */
    protected function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param $connectTimeout
     */
    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = (float)$connectTimeout;
    }

    /**
     * @return float
     */
    protected function getConnectTimeout(): float
    {
        return $this->connectTimeout;
    }

    /**
     * @param HandlerStack $guzzleHandlerStack
     */
    public function setGuzzleHandlerStack(HandlerStack $guzzleHandlerStack)
    {
        $this->guzzleHandlerStack = $guzzleHandlerStack;
    }

    /**
     * @return HandlerStack
     */
    protected function getGuzzleHandlerStack()
    {
        return $this->guzzleHandlerStack;
    }

    /**
     * get default HttpRequest options
     *
     * @return array
     */
    protected function getDefaultHttpRequestOptions(): array
    {
        return [
            'handler'         => $this->getGuzzleHandlerStack(),
            'connect_timeout' => $this->getConnectTimeout(),
            'headers'         => [
                'X-ENVIRONMENT-PHP-VERSION' => \PHP_VERSION,
                'X-ENVIRONMENT-SDK-VERSION' => \strtolower(self::API_USER_AGENT . '-v' . self::SDK_VERSION),
                'API-KEY'                   => $this->getApiKey()
            ]
        ];
    }

    /**
     * @param $apiMethod
     * @param $requestType
     * @param $arHttpRequestOptions
     *
     * @throws \RuntimeException on failure.
     * @throws GuzzleException
     *
     * @return array
     */
    public function executeApiRequest($apiMethod, $requestType, array $arHttpRequestOptions = []): array
    {
        $arResult = [];

        $defaultHttpRequestOptions = \array_merge($arHttpRequestOptions, $this->getDefaultHttpRequestOptions());

        try {
            $this->log->debug(
                'rarus.online.kkt.apiClient.sendRequest',
                [
                    'url'     => $this->apiEndpoint . $apiMethod,
                    'method'  => $apiMethod,
                    'options' => $defaultHttpRequestOptions
                ]
            );

            $obResponse = $this->httpClient->request(
                $requestType,
                $this->apiEndpoint . $apiMethod,
                $defaultHttpRequestOptions
            );

            $this->log->debug(
                'rarus.online.kkt.apiClient.sendRequest.response',
                [
                    'response'     => $obResponse->getStatusCode(),
                    'reasonPhrase' => $obResponse->getReasonPhrase()
                ]
            );

            $obResponseBody = $obResponse->getBody();
            $obResponseBody->rewind();

            $arResult = $this->decodeApiJsonResponse($obResponseBody->getContents());

        } catch (ClientException $e) {
            $this->handleApiErrors($e);
        } catch (BadResponseException $e) {
            $this->handleApiErrors($e);
        }

        $this->log->debug(
            'rarus.online.kkt.apiClient.sendRequest.Result',
            [
                'arResult' => $arResult
            ]
        );

        return $arResult;
    }

    /**
     * @param \GuzzleHttp\Exception\BadResponseException $e
     *
     * @throws \RuntimeException on failure.
     */
    protected function handleApiErrors(BadResponseException $e)
    {
        $obErrorResponse = $e->getResponse();
        $obStream = $obErrorResponse->getBody();

        $this->log->error(
            \sprintf('http client error [%s]', $e->getMessage()),
            [
                'contents' => $obStream->getContents()
            ]
        );

        switch ($obErrorResponse->getStatusCode()) {
            case StatusCode::STATUS_BAD_REQUEST:
                $errorMessage = \sprintf(
                    'rarus online kkt api: http-code [%s], invalid request(missing required data), ',
                    $obErrorResponse->getStatusCode()
                );
                break;
            case StatusCode::STATUS_NOT_FOUND:
                $errorMessage = \sprintf(
                    'rarus online kkt api: http-code [%s], item not found, ',
                    $obErrorResponse->getStatusCode()
                );
                break;
            case StatusCode::STATUS_INTERNAL_SERVER_ERROR:
                $errorMessage = \sprintf(
                    'rarus online kkt api: http-code [%s], internal server error, ',
                    $obErrorResponse->getStatusCode()
                );
                break;
            default:
                $arServerResponse = $this->decodeApiJsonResponse($obStream->getContents());
                $errorMessage = \sprintf(
                    'rarus online kkt api: code [%s], message [%s], ',
                    $arServerResponse['code'],
                    $arServerResponse['message']
                );

                break;
        }
        $this->log->error($errorMessage);
    }

    /**
     * @param $jsonApiResponse
     *
     * @return mixed
     */
    protected function decodeApiJsonResponse($jsonApiResponse)
    {
        // handling server-side API errors: empty response
        if ($jsonApiResponse === '') {
            $errorMsg = \sprintf('empty response from server');
            $this->log->error($errorMsg);
        }
        // handling json_decode errors
        $jsonResult = \json_decode($jsonApiResponse, true);
        $jsonErrorCode = \json_last_error();
        if (null === $jsonResult && (JSON_ERROR_NONE !== $jsonErrorCode)) {
            $errorMsg = 'fatal error in function json_decode.' . \PHP_EOL . 'Error code: ' . $jsonErrorCode . ' ' .
                \json_last_error_msg() . \PHP_EOL;
            $this->log->error($errorMsg);
        }

        return $jsonResult;
    }
}
