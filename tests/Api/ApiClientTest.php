<?php

use PrestaShop\Module\FakeModule\Api\Fake\FakeApi;
use PrestaShop\Module\FakeModule\Api\Fake\Requests\GetCheckRequest;

it('can send an api request', function () {
    $api = FakeApi::request(new GetCheckRequest());
});
