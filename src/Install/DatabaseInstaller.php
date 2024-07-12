<?php

namespace IBroStudio\ModuleHelper\Install;

use Db;

class DatabaseInstaller
{
    static public function install(array $database): bool
    {
        foreach ($database as $queries) {
            foreach ($queries as $query) {
                if (! Db::getInstance()->execute($query)) {
                    return false;
                }
            }
        }

        return true;
    }

    static public function uninstall(array $database): bool
    {
        foreach (array_keys($database) as $table) {
            if (! Db::getInstance()->execute("DROP TABLE IF EXISTS `'{_DB_PREFIX_.$table}`")) {
                return false;
            }
        }

        return true;
    }
}