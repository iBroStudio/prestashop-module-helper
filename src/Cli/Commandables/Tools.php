<?php

namespace IBroStudio\ModuleHelper\Cli\Commandables;

use IBroStudio\ModuleHelper\Cli\Contracts\Commandable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Tools implements Commandable
{
    protected string $utils;

    public function __construct()
    {
        $this->utils = getcwd() . '/vendor/ibrostudio/prestashop-module-helper/utils';
    }

    public function run($method, $args = []): bool
    {
        $process = match($method) {
            'analyse' => $this->analyse(),
            'auto-index' => $this->autoIndex(),
            'format' => $this->format(),
            'header-stamp' => $this->headerStamp(),
            default => throw new \Exception('Unknown command'),
        };

        $process->setTty(true);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return true;
    }

    private function analyse(): Process
    {
        return new Process(
            command: [
                'vendor/bin/phpstan',
                "--configuration={$this->utils}/phpstan.neon",
                'analyse'
            ]
        );
    }

    private function autoIndex(): Process
    {
        return new Process(
            command: [
                'vendor/bin/autoindex',
                'prestashop:add:index',
                './'
            ]
        );
    }

    private function format(): Process
    {
        return new Process(
            command: [
                PHP_BINARY,
                'vendor/bin/php-cs-fixer',
                'fix',
                "--config={$this->utils}/.php-cs-fixer.dist.php",
            ]
        );
    }

    private function headerStamp(): Process
    {
        return new Process(
            command: [
                'vendor/bin/header-stamp',
                '--license=./.header-stamp',
                '--exclude=node_modules,vendor'
            ]
        );
    }
}
