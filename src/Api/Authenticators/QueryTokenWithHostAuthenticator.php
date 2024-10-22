<?php

namespace IBroStudio\ModuleHelper\Api\Authenticators;

use Saloon\Http\PendingRequest;
use Saloon\Contracts\Authenticator;
use Symfony\Component\HttpFoundation\Request;

class QueryTokenWithHostAuthenticator implements Authenticator
{
    public function __construct(
        public readonly string $key,
        public readonly string $token) {}

    public function set(PendingRequest $pendingRequest): void
    {
        $request = Request::createFromGlobals();

        $pendingRequest->query()
            ->add('host', $request->getSchemeAndHttpHost())
            ->add($this->key, $this->token);
    }
}