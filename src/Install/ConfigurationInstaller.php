<?php

namespace IBroStudio\ModuleHelper\Install;

use IBroStudio\ModuleHelper\Enums\Contracts\ConfigContract;

class ConfigurationInstaller
{
    public static function install(array $configuration): bool
    {
        foreach ($configuration as $value) {
            /* @var $value ConfigContract */
            if (! $value->set($value->default())) {
                return false;
            }
        }

        return true;
    }

    public static function uninstall(array $configuration): bool
    {
        foreach ($configuration as $value) {
            /* @var $value ConfigContract */
            if (! $value->delete()) {
                return false;
            }
        }

        return true;
    }
}
