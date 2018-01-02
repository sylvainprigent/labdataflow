<?php
namespace Modules\Auth\ServerRoutes;

use \Mumux\Server\Route;
use \Firebase\JWT\JWT;

class InstallRoutes extends Route
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    public function install()
    {

        // call apdate for cache database 
        $updateRouter = new \Mumux\UpdateRouter();
        $updateRouter->routerRequest(false);

        // create the default user
        $this->getRepository("Auth::UserRepository")
            ->createDefaultUser();
        
        echo \json_encode(array("status" => "success", "Messsage" => "The database has been initialised"));

    }

 


}