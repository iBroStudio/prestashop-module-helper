<?php

namespace IBroStudio\ModuleHelper\Api;

use IBroStudio\ModuleHelper\Api\Data\ApiConfigData;
use IBroStudio\ModuleHelper\Cli\Contracts\Commandable;
use Saloon\Http\Request;
use Saloon\Http\Response;

abstract class ApiClient implements Commandable
{
    const AUTH = null;

    const QUERY_TOKEN_KEY = null;

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
        if (! isset(self::$instance)) {
            self::$instance = new static();
        }

        return (new ApiConnector(...self::$instance->config->toArray()))->send($request);
    }

    public static function install(): bool
    {
        return (new ApiInstaller(new static(loadConfig: false)))->install();
    }

    public static function uninstall(): bool
    {
        return (new ApiInstaller(new static()))->uninstall();
    }
}
