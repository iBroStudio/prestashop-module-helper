<?php

namespace IBroStudio\ModuleHelper\Install;

use Configuration;

class ConfigurationInstaller
{
    public static function install(array $configuration): bool
    {
        foreach ($configuration as $key => $value) {
            if (! Configuration::updateValue($key, $value)) {
                return false;
            }
        }

        return true;
    }

    public static function uninstall(array $configuration): bool
    {
        foreach (array_keys($configuration) as $key) {
            if (! Configuration::deleteByName($key)) {
                return false;
            }
        }

        return true;
    }
}
