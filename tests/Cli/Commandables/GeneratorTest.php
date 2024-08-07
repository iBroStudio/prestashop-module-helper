<?php

use IBroStudio\ModuleHelper\Cli\Commandables\Generator;

it('can instantiate Api commandable', function () {
    $generator = (new Generator())->run('test');

    expect($generator)->toBeTrue();
});
