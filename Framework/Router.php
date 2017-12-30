<?php

namespace Mumux;

class Router
{

    public function routerRequest()
    {


        $route = "";
        if (isset($_GET["path"])) {
            $route = $_GET["path"];
        }
        
        //echo "route = " . $route . "<br/>";

        $updateUrl = "update";
        if (strpos($route, $updateUrl) !== false) {
            $updateRouter = new UpdateRouter();
            $updateRouter->routerRequest();
            return;
        }

        $apibase = Configuration::get("rootapi");

        //echo "apibase = " . $apibase . "<br/>"; 

        if (strpos($route, $apibase) !== false) {
            $apiRouter = new Server\Router();
            $apiRouter->routerRequest();
        } else {
            $clientRouter = new Client\Router();
            $clientRouter->routerRequest();
        }
    }
}