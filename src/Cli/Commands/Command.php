<?php

namespace IBroStudio\ModuleHelper\Cli\Commands;

use IBroStudio\ModuleHelper\Cli\Contracts\Commandable;
use InvalidArgumentException;
use ReflectionClass;

class Command
{
    protected ?Commandable $class = null;

    public function getClass()
    {
        return new ReflectionClass($this->getFullyQualifiedClass($namespace, $className));
    }

    public function getInstance()
    {
        if ($this->getClass()->getMethod($this->method)->isStatic()) {
            return $this->class->newInstanceWithoutConstructor();
        }

        $constructor = $this->getClass()->getConstructor();

        if (! $constructor) {

            return $this->getClass()->newInstance();
        }

        $params = $constructor->getParameters();

        if (! $params) {

            return $this->getClass()->newInstance();
        }

        throw new \Exception($this->getClass()->getName().' needs aarguments in constructor');
    }

    public function run($method, $args = []): bool
    {
        if (! $this->class->hasMethod($method)) {
            throw new InvalidArgumentException("Method [$method] not found in [{$this->class->getName()}]");
        }

        $this->instance->$method();

        return true;
    }
}
