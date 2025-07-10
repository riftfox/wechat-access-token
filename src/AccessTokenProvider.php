<?php

namespace Riftfox\Wechat\AccessToken;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriFactoryInterface;
use Riftfox\Wechat\Application\ApplicationInterface;
use Riftfox\Wechat\Exception\ExceptionFactoryInterface;
use Riftfox\Wechat\Token\TokenFactoryInterface;
use Riftfox\Wechat\Token\TokenProvider;

class AccessTokenProvider extends TokenProvider
{
    private RequestFactoryInterface $requestFactory;
    private UriFactoryInterface $uriFactory;
    public function __construct(ClientInterface $client,
                                RequestFactoryInterface $requestFactory,
                                UriFactoryInterface $uriFactory,
                                TokenFactoryInterface $tokenFactory,
                                ExceptionFactoryInterface $exceptionFactory)
    {
        parent::__construct($client, $tokenFactory, $exceptionFactory);
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
    }

    public function getRequest(ApplicationInterface $application, bool $forceRefresh = false): RequestInterface
    {
        $uri = $this->uriFactory->createUri(self::TOKEN_URL);
        $uri->withQuery(http_build_query([
            'grant_type' => 'client_credential',
            'appid' => $application->getAppId(),
            'secret' => $application->getAppSecret(),
        ]));
        // TODO: Implement getRequest() method.
        return $this->requestFactory->createRequest('GET',$uri);
    }
}