<?php
namespace Modules\Auth\ServerRoutes;

use \Mumux\Server\Route;
use \Firebase\JWT\JWT;

class AuthRoutes extends Route
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);

        // check token
        $authHeader = $this->request->getHeader("Authorization");
        if ($authHeader) {
            //try {
                $headerInfo = \explode(" ", $authHeader);
                $jwt = $headerInfo[1];

                $secretKey = \Mumux\Configuration::get('jwtkey');
                $token = JWT::decode($jwt, $secretKey, array('HS512'));
                return (Array)$token;

            //} catch (\Exception $e) {
            //    throw new \Exception("Token not valid");
            //}
        } else {
            throw new \Exception("Token not found");
        }

    }
}