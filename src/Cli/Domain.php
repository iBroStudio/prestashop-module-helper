<?php

namespace IBroStudio\ModuleHelper\Cli;

use IBroStudio\ModuleHelper\Cli\Contracts\AccessibleFromCli;
use InvalidArgumentException;
use ReflectionClass;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class Domain
{
    public function __construct(
        protected ?ReflectionClass $class = null,
        protected ?AccessibleFromCli $instance = null,
    ){}

    abstract protected function getFullyQualifiedClass(string $namespace, string $className): string;

    public function with(string $namespace, string|SymfonyStyle $className): self
    {
        if ($className instanceof SymfonyStyle) {
            $className = $this->interactForClassName($className);
        }

        $this->class = new ReflectionClass($this->getFullyQualifiedClass($namespace, $className));
        $this->instance =  $this->class->newInstanceWithoutConstructor();

        return $this;
    }

    public function run($method, $args = []): bool
    {
        if (! $this->class->hasMethod($method)) {
            throw new InvalidArgumentException("Method [$method] not found in [{$this->class->getName()}]");
        }

        $this->instance->$method();

        return true;
    }

    protected function interactForClassName(SymfonyStyle $io): string|null
    {
        return null;
    }
}