<?php

namespace IBroStudio\ModuleHelper\Api\AuthManagers;

use IBroStudio\ModuleHelper\Enums\EnvModes;
use IBroStudio\ModuleHelper\Enums\KeySuffixes;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\HeaderAuthenticator;

class HeaderAuthManager extends AuthManager
{
    protected array $productionConfigKeys = [
        KeySuffixes::PRODUCTION_HEADER,
        KeySuffixes::PRODUCTION_TOKEN,
    ];

    protected array $testConfigKeys = [
        KeySuffixes::TEST_HEADER,
        KeySuffixes::TEST_TOKEN,
    ];

    public function getAuthenticator(EnvModes $mode): ?Authenticator
    {
        return new HeaderAuthenticator(
            ...$this->getFromDb($this->getConfigKeys($mode))
        );
    }
}
