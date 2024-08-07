<?php

namespace IBroStudio\ModuleHelper\Cli;

class CliCommandClass
{
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
}
