<?php

namespace IBroStudio\ModuleHelper\Cli\Commandables;

use IBroStudio\ModuleHelper\Cli\Concerns\ClassIsSelectable;
use IBroStudio\ModuleHelper\Cli\Concerns\HasReflection;
use IBroStudio\ModuleHelper\Cli\Contracts\Commandable;
use IBroStudio\ModuleHelper\Cli\Contracts\SelectableClass;
use InvalidArgumentException;

class Api implements Commandable, SelectableClass
{
    use ClassIsSelectable;
    use HasReflection;

    public function __construct(protected string $namespace, protected ?string $class = null)
    {}

    public function run($method, $args = []): bool
    {
        $instance = $this->instantiateClass($method);

        /*
        if (! method_exists($this->class, $method)) {
            throw new InvalidArgumentException("Method [$method] not found in " . get_class($this->class));
        }
*/

        try {
            $instance->$method();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function classSelectLabel(): string
    {
        return 'Select Api';
    }

    public function classList(): array
    {
        return array_map(function ($directory) {
            return basename($directory);
        }, glob(getcwd().'/src/Api/*', GLOB_ONLYDIR));
    }

    protected function getFullyQualifiedClass(): string
    {
        return "{$this->namespace}Api\\{$this->class}\\{$this->class}Api";
    }
}
