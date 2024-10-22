<?php

namespace IBroStudio\ModuleHelper\Api\AuthManagers;

use Configuration;
use IBroStudio\ModuleHelper\Api\ApiClient;
use IBroStudio\ModuleHelper\Api\Concerns\InteractsWithModule;
use IBroStudio\ModuleHelper\Enums\EnvModes;
use Saloon\Contracts\Authenticator;

abstract class AuthManager
{
    use InteractsWithModule;

    protected array $productionConfigKeys = [];

    protected array $testConfigKeys = [];

    abstract public function getAuthenticator(EnvModes $mode): ?Authenticator;

    public function __construct(public string $config_key_prefix, protected ApiClient $api) {}

    public function getConfigKeys(?EnvModes $mode = null): array
    {
        return match ($mode) {
            EnvModes::PRODUCTION => $this->productionConfigKeys,
            EnvModes::TEST => $this->testConfigKeys,
            default => array_merge($this->productionConfigKeys, $this->testConfigKeys),
        };
    }

    protected function getFromDb(string|array $suffix): string|array|null
    {
        //print_r($this->addConfigKeyPrefix($suffix)); die();
        if (is_array($suffix)) {
            return Configuration::getMultiple($this->addConfigKeyPrefix($suffix));
        }

        return Configuration::get($this->addConfigKeyPrefix($suffix));
    }
}
