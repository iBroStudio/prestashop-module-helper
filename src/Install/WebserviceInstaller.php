<?php

namespace IBroStudio\ModuleHelper\Install;

use Configuration;
use Module;
use Tools;
use WebserviceKey;

class WebserviceInstaller
{
    public static function install(Module $module, array $permissions): bool
    {
        $webservice = new WebserviceKey();
        $webservice->key = Tools::passwdGen(32);
        $webservice->description = "{$module->displayName} Webservice";
        $webservice->is_module = 1;
        $webservice->module_name = $module->name;
        $webservice->save();

        if ($webservice) {

            Configuration::updateValue(strtoupper($module->name).'_WEBSERVICE_ID', $webservice->id);

            WebserviceKey::setPermissionForAccount($webservice->id, $permissions);

            Configuration::updateValue('PS_WEBSERVICE', 1);

            return true;
        }

        return false;
    }

    public static function uninstall(Module $module): bool
    {
        $webservice_configuration_key = strtoupper($module->name).'_WEBSERVICE_ID';
        $webservice = new WebserviceKey(Configuration::get($webservice_configuration_key));

        return $webservice->delete()
            && Configuration::deleteByName($webservice_configuration_key);
    }
}
