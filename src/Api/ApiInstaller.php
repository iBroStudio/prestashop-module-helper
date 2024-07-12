<?php

namespace IBroStudio\ModuleHelper\Api;

use IBroStudio\ModuleHelper\Api\Concerns\InteractsWithModule;
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

        //TODO: add baseUrl in .env files

        return true;
    }

    public function uninstall(): bool
    {
        if (count($this->configuration)
            && ! ConfigurationInstaller::uninstall($this->configuration)) {
            return false;
        }

        //TODO: removes baseUrl in .env files

        return true;
    }
}