<?php

namespace Mumux\server;

class RepositoryFactory
{
    public static function getRepository($name)
    {

        // Model name
        $nameArray = \explode("::", $name);
        $moduleName = $nameArray[0];
        $modelName = \str_replace("Repository", "", $nameArray[1]);

        // get the repository class name
        $className = "\\Modules\\" . $moduleName . "\\ServerServices\\" . $nameArray[1];

        if (! (Registery::get($name) instanceof $className)) {

            // get the model Name
            $modelName = "\\Modules\\".$moduleName."\\ServerServices\\" . $modelName . "Model";
            $model = new $modelName();

            $repository = new $className($model);
            Registery::set($name, $repository);
        }
        return Registery::get($name);
    }
}