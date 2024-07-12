<?php

namespace IBroStudio\ModuleHelper\Env;

use Configuration;
use Dotenv\Dotenv;
use Dotenv\Environment\Adapter\EnvConstAdapter;
use Dotenv\Environment\Adapter\PutenvAdapter;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Repository\Adapter\EnvConstAdapter as RepositoryEnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter as RepositoryPutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use IBroStudio\ModuleHelper\Enums\EnvModes;
use IBroStudio\ModuleHelper\Enums\KeySuffixes;
use IBroStudio\ModuleHelper\Exceptions\EnvKeyNotFoundException;
use IBroStudio\ModuleHelper\Exceptions\MissingEnvFileException;
use Module;

class EnvManager
{
    private static array $instance;

    private function __construct(Module $module, ?EnvModes $mode)
    {
        if (is_null($mode)) {
            $mode = Configuration::get($module->name . '_' . KeySuffixes::ENV_MODE);
        }

        $env_filename = '.env.' . $mode;
        $env_filepath = _PS_MODULE_DIR_ . $module->name . '/' . $env_filename;

        if (!file_exists($env_filepath)) {
            throw new MissingEnvFileException("{$env_filepath} does not exist");
        }

        Dotenv::create(_PS_MODULE_DIR_ . $module->name, $env_filename)->load();
    }

    public static function load(string $name, ?EnvModes $mode = null): self
    {
        if (array_key_exists($name, self::$instance)) {
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

    public function put(array $data)
    {
// Load the .env file into a repository
        $repository = RepositoryBuilder::create()
            ->withReaders([
                new RepositoryEnvConstAdapter(new EnvConstAdapter()),
            ])
            ->withWriters([
                new RepositoryPutenvAdapter(new PutenvAdapter()),
            ])
            ->immutable()
            ->make();

// Loop through the data and update the values
        foreach ($data as $key => $value) {
            $repository->set($key, $value);
        }

// Save the changes back to the .env file
        $factory = new DotenvFactory($repository, true);
        $dotenv = Dotenv::create($repository, $factory);
        $dotenv->safeLoad();
        $dotenv->toEnv();
    }
}

// EnvManager::load($module)->get('key')