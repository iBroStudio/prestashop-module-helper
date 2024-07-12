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
        $this->module_name = $this->guessModuleName();
        $this->module_key = strtoupper($this->module_name) . '_';
        $this->config_key_prefix = $this->module_key . strtoupper(get_class($this->api)) . '_';
        $this->mode = Configuration::get($this->module_key . KeySuffixes::ENV_MODE->value);
    }

    protected function guessModuleName(): string
    {
        $class = new \ReflectionClass(get_class($this));
        preg_match('/\/modules\/(.*?)\/src/', $class->getFileName(), $matches);

        return $matches[1];
    }

    protected function addConfigKeyPrefix(string|array $suffix): string|array
    {
        if (is_array($suffix)) {
            return array_map(fn($item): string => $this->config_key_prefix . $item, $suffix);
        }

        return $this->config_key_prefix . $suffix;
    }
}