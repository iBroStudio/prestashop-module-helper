<?php

namespace IBroStudio\ModuleHelper\Env;

use Configuration;
use Dotenv\Dotenv;
use IBroStudio\ModuleHelper\Enums\EnvModes;
use IBroStudio\ModuleHelper\Enums\KeySuffixes;
use IBroStudio\ModuleHelper\Exceptions\EnvKeyNotFoundException;
use IBroStudio\ModuleHelper\Exceptions\MissingEnvFileException;
use MirazMac\DotEnv\Writer;
use Module;

class EnvManager
{
    private static array $instance;

    private function __construct(Module $module, ?EnvModes $mode)
    {
        if (is_null($mode)) {
            $mode = Configuration::get(key: $module->name.'_'.KeySuffixes::ENV_MODE->value, default: null) ?? EnvModes::PRODUCTION;
        }

        $env_filename = '.env.'.$mode->value;
        $env_filepath = _PS_MODULE_DIR_.$module->name.'/'.$env_filename;

        if (! file_exists($env_filepath)) {
            throw new MissingEnvFileException("{$env_filepath} does not exist");
        }

        Dotenv::create(_PS_MODULE_DIR_.$module->name, $env_filename)->load();
    }

    public static function load(string $name, ?EnvModes $mode = null): self
    {
        if (isset(self::$instance) && array_key_exists($name, self::$instance)) {
            return self::$instance[$name];
        }

        if (! $module = Module::getInstanceByName($name)) {
            throw new EnvKeyNotFoundException("Env key '{$name}' not found");
        }

        return self::$instance[$module->name] = new self($module, $mode);
    }

    public function get(string $key): string
    {
        if (! array_key_exists($key, $_ENV)) {
            throw new EnvKeyNotFoundException("{$key} key does not exist in env");
        }

        return $_ENV[$key];
    }

    public static function add(string $name, array $data): bool
    {
        $module = Module::getInstanceByName($name);

        foreach (['production', 'test'] as $mode) {
            if (file_exists($file =_PS_MODULE_DIR_.$module->name.'/.env.'.$mode)) {
                $contents = file_get_contents($file);
                $lines = explode("\n", $contents);

                foreach ($lines as &$line) {

                    if (empty($line) || substr($line, 0, 1) === '#') {
                        continue;
                    }

                    $parts = explode('=', $line, 2);
                    $key = $parts[0];

                    if (isset($data[$key])) {
                        $line = $key . '=' . $data[$key];
                        unset($data[$key]);
                    }
                }

                foreach ($data as $key => $value) {
                    $lines[] = $key . '=' . $value;
                }

                $contents = implode("\n", $lines);

                file_put_contents(_PS_MODULE_DIR_.$module->name.'/.env.'.$mode, $contents);
            }
        }

        return true;
    }

    public static function remove(string $name, array $data): bool
    {
        $module = Module::getInstanceByName($name);

        foreach (['production', 'test'] as $mode) {
            if (file_exists($file =_PS_MODULE_DIR_.$module->name.'/.env.'.$mode)) {
                $contents = file_get_contents($file);
                $lines = explode("\n", $contents);

                foreach ($lines as &$line) {

                    if (empty($line) || substr($line, 0, 1) === '#') {
                        continue;
                    }

                    $parts = explode('=', $line, 2);
                    $key = $parts[0];

                    if (isset($data[$key])) {
                        unset($lines[$key]);
                    }
                }

                $contents = implode("\n", $lines);

                file_put_contents(_PS_MODULE_DIR_.$module->name.'/.env.'.$mode, $contents);
            }
        }

        return true;
    }
}
