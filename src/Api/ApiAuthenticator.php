<?php

namespace IBroStudio\ModuleHelper\Api;

use IBroStudio\ModuleHelper\Enums\EnvModes;
use Saloon\Contracts\Authenticator;

class ApiAuthenticator
{
    public function __construct(
        protected string $authenticator,
        public EnvModes $mode,
        public string $config_key_prefix
    ) {}

    public function getAuthenticator(): ?Authenticator
    {
        return (new $this->authenticator($this->config_key_prefix))
            ->getAuthenticator($this->mode);
    }
}
