<?php

namespace IBroStudio\ModuleHelper\Cli;

use function Laravel\Prompts\info;
use function Laravel\Prompts\select;

final class Cli
{
    public function __construct(
        public readonly Registry $registry,
        public ?string $namespace = null,
        protected ?string $domain = null,
        protected string|array|null $method = null,
        protected array $params = []
    ) {}

    private function defineNamespace(): void
    {
        $composer = json_decode((string) file_get_contents(getcwd().'/composer.json'), true);

        if (! $this->namespace = array_search('src/', $composer['autoload']['psr-4'])) {
            throw new \RuntimeException('Unable to define namespace from composer.json');
        }
    }

    public function build(): bool
    {
        $this->defineNamespace();

        $this->selectDomain();

        while (! is_array($this->method)) {
            $this->method = $this->selectMethod();
        }

        /*
        info(print_r($this->getCommandableClass()));

        CliCommand::for($this->namespace, $this->params)
            ->load($this->getCommandableClass());

        return true;
        */

        if (CliCommand::for($this->namespace, $this->params)
            ->load($this->getCommandableClass())
            ->run(current($this->method))) {
            info('Command successfully executed.');
        }

        return true;
    }

    public static function parseArgv(array $argv): array
    {
        $parsed = [];

        foreach ($argv as $arg) {
            if (count($items = explode('=', $arg)) > 1) {
                [$key, $value] = $items;
                if (in_array($key, ['domain', 'method', 'namespace'])) {
                    $parsed[$key] = $value;
                } else {
                    $parsed['params'][$key] = $value;
                }
            }
        }

        return $parsed;
    }

    private function selectDomain(): void
    {
        if (is_null($this->domain)) {
            $this->domain = select(
                'Domain',
                $this->registry->getDomains()
            );
        }

        $this->registry->setDomain($this->domain);
    }

    private function selectMethod(): ?array
    {
        if (is_null($this->method)) {
            $this->method = select(
                'Action',
                $this->registry->getMethods()
            );
        }

        return $this->registry->setMethod($this->method);
    }

    private function getCommandableClass(): ?string
    {
        return $this->method ? key($this->method) : null;
    }
}
