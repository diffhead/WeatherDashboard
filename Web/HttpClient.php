<?php namespace Web;

use CurlHandle;

use Services\JsonService;
use Services\HttpService;
use Services\StringService;

use Interfaces\Web\HttpHeader;
use Interfaces\Web\HttpRequest;
use Interfaces\Web\HttpResponse;

use Factories\Web\HttpResponseFactory;

class HttpClient
{
    private CurlHandle   $curl;

    private HttpRequest  $request;
    private HttpResponse $response;

    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    public function sendRequest(): bool
    {
        $this->initCurl();

        if ( $this->request->getMethod() === 'POST' ) {
            $this->curlSetOpt(CURLOPT_POST, 1);
            $this->curlSetOpt(CURLOPT_POSTFIELDS, $this->request->getData());
        }

        $this->curlSetOpt(CURLOPT_HEADER, 1);
        $this->curlSetOpt(CURLOPT_RETURNTRANSFER, 1);

        $this->loadRequestHeaders();
        $this->loadRequestCookies();

        return $this->curlExec();
    }

    public function getResponse(): null|HttpResponse
    {
        if ( isset($this->response) === false ) {
            return null;
        }

        return $this->response;
    }

    public function curlError(): int
    {
        if ( $this->isCurlInited() === false ) {
            return 0;
        }

        return curl_errno($this->curl);
    }

    private function initCurl(): void
    {
        $this->curl = curl_init($this->request->getUrl());
    }

    private function curlSetOpt(int $curlOption, mixed $value): bool
    {
        return $this->isCurlInited() ? curl_setopt($this->curl, $curlOption, $value) : false;
    }

    private function isCurlInited(): bool
    {
        return isset($this->curl);
    }

    private function loadRequestHeaders(): bool
    {
        $status = true;

        foreach ( $this->request->getHeaders() as $header ) {
            if ( HttpService::isHeader($header) ) {
                $status &= $this->curlSetOpt(CURLOPT_HTTPHEADER, $header->getRaw());
            }
        }

        return $status;
    }

    private function loadRequestCookies(): bool
    {
        $status = true;

        foreach ( $this->request->getCookies() as $cookie ) {
            if ( HttpService::isCookie($cookie) ) {
                $status &= $this->curlSetOpt(CURLOPT_HTTPHEADER, HttpService::cookieToCurlOptValue($cookie));
            }
        }

        return $status;
    }

    private function curlExec(): bool
    {
        if ( $this->isCurlInited() === false ) {
            return false;
        }

        $curlResult = curl_exec($this->curl);

        if ( $this->curlError() !== 0 ) {
            return false;
        }

        $curlCode = (int)$this->curlInfo(CURLINFO_HTTP_CODE);
        $curlHeaderSize = (int)$this->curlInfo(CURLINFO_HEADER_SIZE);
        $curlContentType = $this->curlInfo(CURLINFO_CONTENT_TYPE);

        $curlHead = StringService::subString($curlResult, 0, $curlHeaderSize);
        $curlBody = StringService::subString($curlResult, $curlHeaderSize);

        $curlHeaders = HttpService::getHeadersFromSplittedHead(StringService::explode($curlHead, PHP_EOL));
        $curlCookies = [];

        foreach ( $curlHeaders as $header ) {
            if ( $header->getName() === 'set-cookie' ) {
                $curlCookies[] = HttpService::getCookieFromSetCookieHeader($header);
            }
        }

        $curlData = '';

        if ( StringService::strPosition($curlContentType, 'application/json') !== -1 ) {
            $curlData = [];
            $curlJson = JsonService::decode($curlBody);

            if ( JsonService::lastError() === JSON_ERROR_NONE ) {
                $curlData = $curlJson;
            }
        } else {
            $curlData = $curlBody;
        }

        if ( $this->curlError() !== 0 ) {
            $this->response = HttpResponseFactory::get(0, $curlData, [], [], false);
        } else {
            $this->response = HttpResponseFactory::get($curlCode, $curlData, $curlHeaders, $curlCookies);
        }

        $this->curlClose();

        return true;
    }

    private function curlInfo(int $option): mixed
    {
        if ( $this->isCurlInited() === false ) {
            return null;
        }

        return curl_getinfo($this->curl, $option);
    }

    private function curlClose(): void
    {
        curl_close($this->curl);
    }
}
