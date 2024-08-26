<?php

namespace IBroStudio\ModuleHelper\Cli\Concerns;

use ReflectionClass;

trait HasReflection
{
    protected ReflectionClass $reflection;

    public function reflectClass(): void
    {
        $this->reflection = new ReflectionClass($this->getFullyQualifiedClass());
    }

    public function instantiateClass(string $method)
    {
        if ($this->reflection->getMethod($method)->isStatic()) {
            return $this->reflection->newInstanceWithoutConstructor();
        }

        $constructor = $this->reflection->getConstructor();

        if (! $constructor) {
            return $this->reflection->newInstance();
        }

        $params = $constructor->getParameters();

        if (! $params) {
            return $this->reflection->newInstance();
        }

        throw new \Exception($this->reflection->getName().' needs arguments in constructor');
    }
}
