<?php

namespace IBroStudio\ModuleHelper\Api\AuthManagers;

use IBroStudio\ModuleHelper\Enums\EnvModes;
use IBroStudio\ModuleHelper\Enums\KeySuffixes;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\BasicAuthenticator;

class BasicAuthManager extends AuthManager
{
    protected array $productionConfigKeys = [
        KeySuffixes::PRODUCTION_USERNAME,
        KeySuffixes::PRODUCTION_PASSWORD,
    ];

    protected array $testConfigKeys = [
        KeySuffixes::TEST_USERNAME,
        KeySuffixes::TEST_PASSWORD,
    ];

    public function getAuthenticator(EnvModes $mode): ?Authenticator
    {
        return new BasicAuthenticator(
            ...$this->getFromDb($this->getConfigKeys($mode))
        );
    }
}
