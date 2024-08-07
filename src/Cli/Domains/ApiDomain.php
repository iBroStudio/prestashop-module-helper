<?php

namespace IBroStudio\ModuleHelper\Cli\Domains;

use IBroStudio\ModuleHelper\Cli\Domain;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ApiDomain extends Domain
{
    protected function getFullyQualifiedClass(string $namespace, string $className): string
    {
        return "{$namespace}Api\\{$className}\\{$className}Api";
    }

    protected function interactForClassName(SymfonyStyle $io): ?string
    {
        $apiList = array_map(function ($directory) {
            return basename($directory);
        }, glob(getcwd().'/src/Api/*', GLOB_ONLYDIR));

        if (! count($apiList)) {
            $io->error('No API directory found');

            exit;
        }

        return $io->choice('Choose API', $apiList, 0);
    }
}
