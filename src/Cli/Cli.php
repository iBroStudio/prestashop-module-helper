<?php

namespace IBroStudio\ModuleHelper\Cli;

use IBroStudio\ModuleHelper\Cli\Domains\ApiDomain;
use InvalidArgumentException;

final class Cli
{
    public static function domain(string $domain)
    {
        $method = 'create'.ucfirst(strtolower($domain)).'Domain';

        if (method_exists(Cli::class, $method)) {
            return self::$method();
        }

        throw new InvalidArgumentException("Domain [$domain] not supported.");
    }

    public static function createApiDomain()
    {
        return new ApiDomain();
    }
}
