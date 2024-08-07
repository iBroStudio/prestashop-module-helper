<?php

namespace IBroStudio\ModuleHelper\Api\Fake;

use IBroStudio\ModuleHelper\Api\ApiClient;
use IBroStudio\ModuleHelper\Api\AuthManagers\BasicAuthManager;

final class FakeApi extends ApiClient
{
    const AUTH = BasicAuthManager::class;
}
