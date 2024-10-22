<?php

namespace IBroStudio\ModuleHelper\Api\Concerns;

use Configuration;
use IBroStudio\ModuleHelper\Api\ApiClient;
use IBroStudio\ModuleHelper\Enums\EnvModes;
use IBroStudio\ModuleHelper\Enums\KeySuffixes;

trait InteractsWithModule
{
    public EnvModes $mode;

    public string $module_name;

    public string $module_key;

    public string $config_key_prefix;

    protected ApiClient $api;

    protected function definePropertiesFromModule(): void
    {
        $class = new \ReflectionClass($this->api);
        $this->module_name = $this->guessModuleName(
            dirname($class->getFileName()).'/../../../composer.json'
        );
        $this->module_key = strtoupper($this->module_name).'_';
        $this->config_key_prefix = $this->module_key.strtoupper($class->getShortName()).'_';
        $this->mode = Configuration::get(key: $this->module_key.KeySuffixes::ENV_MODE->value, default: null) ?? EnvModes::PRODUCTION;
    }

    protected function guessModuleName(string $composerFile): string
    {
        $composer = json_decode(
            (string) file_get_contents($composerFile),
            true
        );

        if (! array_key_exists('classmap', $composer['autoload'])) {
            throw new \Exception('Unable to find module name in composer.json classmap');
        }

        $name = null;

        foreach ($composer['autoload']['classmap'] as $item) {
            if (str_ends_with($item, '.php')) {
                $name = substr($item, 0 ,strlen($item) - 4);
                break;
            }
        }

        if (is_null($name)) {
            throw new \Exception('Unable to find module name in composer.json classmap');
        }

        return $name;
    }

    protected function addConfigKeyPrefix(string|array $suffix): string|array
    {
        if (is_array($suffix)) {
            return array_map(fn ($item): string => $this->config_key_prefix.$item->value, $suffix);
        }

        return $this->config_key_prefix.$suffix->value;
    }
}
