<?php

namespace IBroStudio\ModuleHelper\Install;

use Module;

abstract class InstallManager
{
    abstract protected function configuration(): array;

    abstract protected function database(): array;

    abstract protected function hooks(): array;

    abstract protected function webservice(): array;

    abstract protected function apiClients(): array;

    private function __construct(
        protected array $database = [],
        protected array $configuration = [],
        protected array $hooks = [],
        protected array $webservice = [],
        protected array $apiClients = []
    ) {
        $this->database = $this->database();
        $this->configuration = $this->configuration();
        $this->hooks = $this->hooks();
        $this->webservice = $this->webservice();
        $this->apiClients = $this->apiClients();
    }

    public static function install(Module $module): bool
    {
        $instance = new static();

        if (count($instance->database)
            && ! DatabaseInstaller::install($instance->configuration)) {
            return false;
        }

        if (count($instance->configuration)
            && ! ConfigurationInstaller::install($instance->configuration)) {
            return false;
        }

        if (count($instance->hooks)
            && ! $module->registerHook($instance->hooks)) {
            return false;
        }

        if (count($instance->webservice)
            && ! WebserviceInstaller::install($module, $instance->webservice)) {
            return false;
        }

        if (count($instance->apiClients)) {
            foreach ($instance->apiClients as $apiClient) {
                if (! $apiClient::install()) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function uninstall(Module $module): bool
    {
        $instance = new static();

        if (count($instance->database)
            && ! DatabaseInstaller::uninstall($instance->configuration)) {
            return false;
        }

        if (count($instance->configuration)
            && ! ConfigurationInstaller::uninstall($instance->configuration)) {
            return false;
        }

        if (count($instance->webservice)
            && ! WebserviceInstaller::uninstall($module)) {
            return false;
        }

        if (count($instance->apiClients)) {
            foreach ($instance->apiClients as $apiClient) {
                if (! $apiClient::uninstall()) {
                    return false;
                }
            }
        }

        return true;
    }
}
