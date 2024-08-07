<?php

namespace IBroStudio\ModuleHelper\Cli\Contracts;

interface SelectableClass
{
    public function classSelectLabel(): string;

    public function classList(): array;
}
