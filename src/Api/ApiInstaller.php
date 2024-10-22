<?php

namespace IBroStudio\ModuleHelper\Api;

use IBroStudio\ModuleHelper\Api\Concerns\InteractsWithModule;
use IBroStudio\ModuleHelper\Enums\KeySuffixes;
use IBroStudio\ModuleHelper\Env\EnvManager;
use IBroStudio\ModuleHelper\Install\ConfigurationInstaller;

class ApiInstaller
{
    use InteractsWithModule;

    private array $configuration = [];

    public function __construct(protected ApiClient $api)
    {
        $this->definePropertiesFromModule();

        if (! is_null($this->api::AUTH)) {
            $this->configuration = (new ($this->api::AUTH)($this->config_key_prefix))
                ->getConfigKeys();
        }
    }

    public function install(): bool
    {
        if (count($this->configuration)
            && ! ConfigurationInstaller::install($this->configuration)) {
            return false;
        }

        EnvManager::add($this->module_name, [
            $this->config_key_prefix.KeySuffixes::BASE_URL->value => "https://api_url"
        ]);

        return true;
    }

    public function uninstall(): bool
    {
        if (count($this->configuration)
            && ! ConfigurationInstaller::uninstall($this->configuration)) {
            return false;
        }

        EnvManager::remove($this->module_name, [
            $this->config_key_prefix.KeySuffixes::BASE_URL->value
        ]);

        return true;
    }
}
