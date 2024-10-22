<?php

namespace IBroStudio\ModuleHelper\Api\Authenticators;

use Saloon\Http\PendingRequest;
use Saloon\Contracts\Authenticator;

class QueryTokenWithHostAuthenticator implements Authenticator
{
    public function __construct(
        public readonly string $key,
        public readonly string $token) {}

    public function set(PendingRequest $pendingRequest): void
    {
        $pendingRequest->query()
            ->add('host', $this->getHttpHost())
            ->add($this->key, $this->token);
    }

    protected function getHttpHost()
    {
        $httpHost = '';
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '') {
            if (isset($_SERVER['HTTPS'])) {
                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
            } else {
                $protocol = 'http';
            }
            $httpHost = $protocol . '://' . $_SERVER['HTTP_HOST'];
        }

        return $httpHost;
    }
}