<?php

namespace IBroStudio\ModuleHelper\Install;

use Configuration;

class ConfigurationInstaller
{
    static public function install(array $configuration): bool
    {
        foreach ($configuration as $key => $value) {
            if (! Configuration::updateValue($key, $value)) {
                return false;
            }
        }

        return true;
    }

    static public function uninstall(array $configuration): bool
    {
        foreach (array_keys($configuration) as $key) {
            if (! Configuration::deleteByName($key)) {
                return false;
            }
        }

        return true;
    }
}