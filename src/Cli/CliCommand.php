<?php

namespace IBroStudio\ModuleHelper\Cli;

use IBroStudio\ModuleHelper\Cli\Contracts\Commandable;
use InvalidArgumentException;

final class CliCommand
{
    private function __construct(
        protected string $namespace,
        protected ?Commandable $commandable = null,
        protected ?string $commanded = null,
        protected ?array $args = null
    ) {}

    public static function for(string $namespace, array $params = []): self
    {
        return new self($namespace, ...$params);
    }

    public function load(string $class): self
    {
        $this->commandable = new $class($this->namespace, $this->commanded);

        return $this;
    }

    public function run($method, $args = []): bool
    {
        if (is_null($this->commandable)) {
            throw new InvalidArgumentException('Commandable is not loaded');
        }

        return $this->commandable->run($method, $args);
    }
}
