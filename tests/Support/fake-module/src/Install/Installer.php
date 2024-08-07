<?php

declare(strict_types=1);

namespace PrestaShop\Module\FakeModule\Install;

use IBroStudio\ModuleHelper\Install\InstallManager;

final class Installer extends InstallManager
{
    /**
     * Keys/values to save in Configuration table
     */
    protected function configuration(): array
    {
        return [
            // 'configuration_key' => 'value',
        ];
    }

    /**
     * Database tables
     */
    protected function database(): array
    {
        return [
            // 'table' => 'install_query',
        ];
    }

    /**
     * Hooks to register
     */
    protected function hooks(): array
    {
        return [
            // 'hook_name',
        ];
    }

    /**
     * Register a web service and its permissions
     */
    protected function webservice(): array
    {
        return [
            // configuration_key => value,
        ];
    }

    /**
     * Install api clients
     */
    protected function apiClients(): array
    {
        return [
            // \PrestaShop\Module\TrusttReviews\Api\Name\NameApi::class
        ];
    }
}
