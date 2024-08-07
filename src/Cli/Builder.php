<?php

namespace IBroStudio\ModuleHelper\Cli;

final class Builder
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
}
