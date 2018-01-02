<?php
namespace Mumux;

class UpdateRouter
{

    public function routerRequest($verbose = true)
    {
        try {
            // update cache
            $cache = new Server\Cache();
            $cache->load();

            // update client cache
            $cachec = new Client\Cache();
            $cachec->load();

            // update database
            $this->updateDatabase();

            if ($verbose){
                echo \json_encode(array("status" => "success", "Messsage" => "cache and database have been updated"));
            }
        } catch (Exception $ex) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $ex->getMessage(),
                    'code' => $ex->getCode(),
                ),
            ));
        }
    }

    protected function updateDatabase()
    {
        $modules = Configuration::get("Modules");
        foreach ($modules as $module) {
            $ModelPath = "Modules/" . $module . "/ServerServices";
            $files = scandir($ModelPath);
            foreach ($files as $file) {
                if (substr($file, -9) === "Model.php") {
                    $className = "\\Modules\\" . $module . "\\ServerServices\\" . substr($file, 0, -4);
                    $model = new $className();
                    
                    $repositoryName = "\\Modules\\" . $module . "\\ServerServices\\" . substr($file, 0, -9) . "Repository";
                    $repository = new $repositoryName($model);
                    $repository->createTable();
                }
            }
        }
    }
}