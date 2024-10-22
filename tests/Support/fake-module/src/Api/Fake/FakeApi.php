<?php

namespace PrestaShop\Module\FakeModule\Api\Fake;

use IBroStudio\ModuleHelper\Api\ApiClient;
use IBroStudio\ModuleHelper\Api\AuthManagers\BasicAuthManager;

class FakeApi extends ApiClient
{
    const AUTH = BasicAuthManager::class;
}