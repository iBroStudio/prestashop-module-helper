<?php

namespace IBroStudio\ModuleHelper\Api\AuthManagers;

use IBroStudio\ModuleHelper\Api\Authenticators\QueryTokenWithHostAuthenticator;
use IBroStudio\ModuleHelper\Enums\EnvModes;
use IBroStudio\ModuleHelper\Enums\KeySuffixes;
use Saloon\Contracts\Authenticator;

class QueryTokenWithHostAuthManager extends AuthManager
{
    protected array $productionConfigKeys = [
        KeySuffixes::PRODUCTION_TOKEN,
    ];

    protected array $testConfigKeys = [
        KeySuffixes::TEST_TOKEN,
    ];

    public function getAuthenticator(EnvModes $mode): ?Authenticator
    {
        return new QueryTokenWithHostAuthenticator(
            $this->api::QUERY_TOKEN_KEY,
            ...array_values(
                $this->getFromDb($this->getConfigKeys($mode))
            )
        );
    }
}
