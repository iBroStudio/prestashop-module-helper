<?php

use IBroStudio\ModuleHelper\Cli\Commandables\Api;

require __DIR__.'/../../../vendor/autoload.php';

it('can instantiate Api commandable', function () {
    $commandable = new Api('IBroStudio\\ModuleHelper\\', 'Fake');

    expect($commandable)->toBeInstanceOf(Api::class);
});

it('can call install method', function () {
    $commandable = new Api('IBroStudio\\ModuleHelper\\', 'Fake');

    expect($commandable->run('install'))->toBeTrue();
});

it('can call uninstall method', function () {
    $commandable = new Api('IBroStudio\\ModuleHelper\\', 'Fake');

    expect($commandable->run('uninstall'))->toBeTrue();
});
