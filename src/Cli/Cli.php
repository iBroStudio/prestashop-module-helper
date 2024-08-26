<?php

namespace IBroStudio\ModuleHelper\Cli;

use function Laravel\Prompts\info;
use function Laravel\Prompts\select;

final class Cli
{
    public function __construct(
        public readonly Registry $registry,
        public readonly string $namespace,
        protected ?string $domain = null,
        protected string|array|null $method = null,
        protected array $params = []
    ) {}

    public function build(): bool
    {
        $this->selectDomain();
        //info(print_r($this->registry->getMethods()));


        while (! is_array($this->method)) {
            $this->method = $this->selectMethod();
        }
        // info(print_r($this->method));  [IBroStudio\ModuleHelper\Cli\Commandables\Api] => install
        CliCommand::for($this->namespace, $this->params)
            ->load($this->getCommandableClass());
        return true;
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
