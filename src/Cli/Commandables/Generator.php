<?php

namespace IBroStudio\ModuleHelper\Cli\Commandables;

use IBroStudio\ModuleHelper\Cli\Contracts\Commandable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Generator implements Commandable
{
    public function run($method, $args = []): bool
    {
        if (is_file(getcwd().'/vendor/bin/presta-generator')) {
            $generator = getcwd().'/vendor/bin/presta-generator';
        } else {
            $generator = getcwd().'/bin/presta-generator';
        }

        $process = new Process([PHP_BINARY, $generator, $method]);
        $process->setTty(true);
        $process->run();

        if (! $process->isSuccessful()) {
            //return false;
            throw new ProcessFailedException($process);
        }

        return true;
    }
}
