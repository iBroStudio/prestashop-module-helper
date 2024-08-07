<?php

use IBroStudio\ModuleHelper\Cli\Commandables\Api;
use IBroStudio\ModuleHelper\Cli\Commandables\Generator;

return [
    'Api' => [
        'Generator' => [
            'Generate new Api Client' => [Generator::class => 'make:api'],
            'Generate new Api Request' => [Generator::class => 'make:api-request'],
        ],
        'Install' => [Api::class => 'install'],
        'Uninstall' => [Api::class => 'uninstall'],
    ],
];
