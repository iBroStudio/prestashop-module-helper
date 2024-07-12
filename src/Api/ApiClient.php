<?php

namespace IBroStudio\ModuleHelper\Api;

use IBroStudio\ModuleHelper\Api\Data\ApiConfigData;
use IBroStudio\ModuleHelper\Cli\Contracts\AccessibleFromCli;
use Saloon\Http\Request;
use Saloon\Http\Response;

abstract class ApiClient implements AccessibleFromCli
{
    const AUTH = null;

    private static ApiClient $instance;

    protected ApiConfigData $config;

    private function __construct(bool $loadConfig = true)
    {
        if ($loadConfig) {
            $this->config = ApiConfiguration::load($this);
        }
    }

    public static function request(Request $request): Response
    {
        if (! self::$instance) {
            self::$instance = new static();
        }

        return (new ApiConnector(...self::$instance->config->toArray()))->send($request);
    }

    public static function install(): bool
    {
        return true;
        return (new ApiInstaller(new static(loadConfig: false)))->install();
    }

    public static function uninstall(): bool
    {
        return (new ApiInstaller(new static(loadConfig: false)))->uninstall();
    }
}