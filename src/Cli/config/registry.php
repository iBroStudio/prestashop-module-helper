<?php

use IBroStudio\ModuleHelper\Cli\Commandables\Api;
use IBroStudio\ModuleHelper\Cli\Commandables\Generator;
use IBroStudio\ModuleHelper\Cli\Commandables\Tools;

return [
    'Api' => [
        'Generator' => [
            'Generate new Api Client' => [Generator::class => 'make:api'],
            'Generate new Api Request' => [Generator::class => 'make:api-request'],
        ],
        'Install' => [Api::class => 'install'],
        'Uninstall' => [Api::class => 'uninstall'],
    ],

    'Configuration' => [
        'Generate new Configuration Page' => [Generator::class => 'make:config-form'],
    ],

    'Tools' => [
        'Analyse code' => [Tools::class => 'analyse'],
        'Auto index' => [Tools::class => 'auto-index'],
        'Format code' => [Tools::class => 'format'],
        'Header stamp' => [Tools::class => 'header-stamp'],
    ]
];
