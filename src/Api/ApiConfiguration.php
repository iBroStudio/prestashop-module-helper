<?php

namespace IBroStudio\ModuleHelper\Api;

use IBroStudio\ModuleHelper\Api\Concerns\InteractsWithModule;
use IBroStudio\ModuleHelper\Api\Data\ApiConfigData;
use IBroStudio\ModuleHelper\Enums\KeySuffixes;
use IBroStudio\ModuleHelper\Env\EnvManager;

class ApiConfiguration
{
    use InteractsWithModule;

    public ApiConfigData $values;

    private ApiAuthenticator $authenticator;

    private function __construct(protected ApiClient $api)
    {
        $this->definePropertiesFromModule();

        $this->authenticator = new ApiAuthenticator(
            authenticator: $this->api::AUTH,
            mode: $this->mode,
            config_key_prefix: $this->config_key_prefix
        );
        $this->values = ApiConfigData::from($this->mapConfig());
    }

    public static function load(ApiClient $api): ApiConfigData
    {
        return (new self($api))->values;
    }

    private function mapConfig(): array
    {
        return [
            'baseUrl' => EnvManager::load($this->module_name, $this->mode)
                ->get($this->config_key_prefix.KeySuffixes::BASE_URL->value),
            'authenticator' => $this->$this->authenticator->getAuthenticator(),
        ];
    }
}
