<?php
namespace Modules\Auth\ServerRoutes;

use \Mumux\Server\Route;
use \Firebase\JWT\JWT;

class LoginRoutes extends Route
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    public function login()
    {
        // check auth
        $loggedIn = $this->getRepository("Auth::UserRepository")
            ->login(
            $this->request->getParameter("login"),
            $this->request->getParameter("password")
        );

        if ($loggedIn) {
            // create a token
            $jwt = AuthRoutes::createTocken($loggedIn);
            $data = array(["status" => "success", "jwt" => $jwt]);
        } else {
            $data = array(["status" => "error", "message" => "Cannot find user with given credentials"]);
        }

        $this->render($data);

    }

 


}