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
            $jwt = $this->createTocken($loggedIn);
            $data = array(["status" => "success", "jwt" => $jwt]);
        } else {
            $data = array(["status" => "error", "message" => "Cannot find user with given credentials"]);
        }

        $this->render($data);

    }

    protected function createTocken($user)
    {

        $tokenId = base64_encode(mcrypt_create_iv(32));
        $issuedAt = time();
        $notBefore = $issuedAt + 10;             //Adding 10 seconds
        $expire = $notBefore + 10*24*3600;            // Adding 60 seconds
        $serverName = \Mumux\Configuration::get('servername'); // Retrieve the server name from config file

        $data = [
            'iat' => $issuedAt,           // Issued at: time when the token was generated
            'jti' => $tokenId,            // Json Token Id: an unique identifier for the token
            'iss' => $serverName,         // Issuer
            'nbf' => $notBefore,          // Not before
            'exp' => $expire,             // Expire
            'data' => [                    // Data related to the signer user
                'userId' => $user['id'],
                'userLogin' => $user['login'],
                'userName' => $user['name'],
                'userFirstname' => $user['firstname'],
                'userStatus' => $user['status_id']
            ]
        ];
    
        // encode
        $secretKey = \Mumux\Configuration::get('jwtkey');
        $jwt = JWT::encode(
            $data,      //Data to be encoded in the JWT
            $secretKey, // The signing key
            'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        return $jwt;

    }


}