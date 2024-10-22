<?php

namespace PrestaShop\Module\FakeModule\Api\Fake\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCheckRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/check';
    }
}
