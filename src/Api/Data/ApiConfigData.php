<?php

namespace IBroStudio\ModuleHelper\Api\Data;

use Saloon\Contracts\Authenticator;

class ApiConfigData
{
    private function __construct(
        public readonly string $baseUrl,
        public readonly Authenticator $authenticator,
    ){}

    public static function from(array $data): ApiConfigData
    {
        return new self(...$data);
    }
    public function toArray(): array
    {
        return [
            'baseUrl' => $this->baseUrl,
            'authenticator' => $this->authenticator
        ];
    }
}