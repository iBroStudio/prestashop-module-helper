<?php

namespace IBroStudio\ModuleHelper\Cli\Concerns;

use function Laravel\Prompts\error;
use function Laravel\Prompts\select;

trait ClassIsSelectable
{
    public function selectClass(): void
    {
        if (is_null($this->class)) {

            if (! count($list = $this->classList())) {
                error('No API found');
                exit;
            }

            $this->class = select(
                $this->classSelectLabel(),
                $list,
            );

        }
    }

    public function classSelectLabel(): string
    {
        return 'Select class';
    }
}
