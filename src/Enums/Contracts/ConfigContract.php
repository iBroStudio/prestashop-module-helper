<?php

namespace IBroStudio\ModuleHelper\Enums\Contracts;

interface ConfigContract
{
    public function default(): string;

    public function field(): array;

    public static function group(string $group): array;

    public static function values(): array;

    public function validate(mixed $value): self;

    public function get(): mixed;

    public function set(mixed $value): bool;

    public function delete(): bool;
}