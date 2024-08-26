<?php

use IBroStudio\ModuleHelper\Cli\Cli;
use IBroStudio\ModuleHelper\Cli\Commandables\Api;
use IBroStudio\ModuleHelper\Cli\Registry;
use Laravel\Prompts\Key;
use Laravel\Prompts\Prompt;

it('can instantiate the cli', function () {
    $cli = new Cli(registry: new Registry(), namespace: 'test');

    expect($cli)->toBeInstanceOf(Cli::class);
});

it('can run a cli command', function () {

    Prompt::fake([
        Key::ENTER,
        Key::DOWN,
        Key::ENTER,
        Key::DOWN,
        Key::DOWN,
        Key::DOWN,
        Key::ENTER,
    ]);

    $commandable = Mockery::mock(Api::class, ['IBroStudio\ModuleHelper\\']);
    $commandable->shouldReceive('run')->withArgs(['install'])->andReturnTrue();

    $command = (new Cli(registry: new Registry(), namespace: 'IBroStudio\ModuleHelper\\'))
        ->build();

    expect($command)->toBeTrue();
});