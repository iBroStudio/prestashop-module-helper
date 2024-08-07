<?php

namespace IBroStudio\ModuleHelper\Cli;

final class Registry
{
    public function __construct(
        private array $items = [],
        private array $reduced = []
    ) {
        $this->items = require __DIR__.'/config/registry.php';

        if (file_exists(getcwd().'/src/Cli/config/registry.php')) {
            $this->items = array_merge($this->items, require getcwd().'/src/Cli/config/registry.php');
        }

        $this->reduced = $this->items;
    }

    public function getDomains(): array
    {
        return array_keys($this->items);
    }

    public function setDomain(string $key): string
    {
        $this->reduceTo($key);

        return $key;
    }

    public function getMethods(): array
    {
        return array_keys($this->reduced);
    }

    public function setMethod($key): ?array
    {
        if (count($this->reduced[$key]) > 1) {
            $this->reduceTo($key);

            return null;
        }

        return $this->reduced[$key];
    }

    private function reduceTo(string $key)
    {
        return $this->reduced = $this->reduced[$key];
    }
}
