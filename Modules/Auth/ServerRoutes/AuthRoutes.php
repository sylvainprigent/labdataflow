<?php
namespace Modules\Auth\ServerRoutes;

use \Mumux\Server\Route;
use \Mumux\Configuration;
use \Firebase\JWT\JWT;

class AuthRoutes extends Route
{
    protected $token;
    protected $user;

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);

        // check token
        $this->updatetoken($request);

    }

    public function render(Array $data)
    {
        $dataout = array(
            "jwt" => $this->token,
            "data" => $data
        );

        header('Content-Type: application/json');
        echo \json_encode($dataout);
    }
    
    // useless function (example how to use token)
    public static function checkToken($request){
        $authHeader = $request->getHeader("Authorization");
        if ($authHeader) {
            try{
                $headerInfo = \explode(" ", $authHeader);
                $jwt = $headerInfo[1];

                $secretKey = Configuration::get('jwtkey');
                $token = JWT::decode($jwt, $secretKey, array('HS512'));
                return true;
            } catch (Exception $ex) {
                return false;
            }
        }
        return false;
    }

    public function updatetoken($request)
    {
        $authHeader = $request->getHeader("Authorization");
        if ($authHeader) {
            try{
                $headerInfo = \explode(" ", $authHeader);
                if (count ($headerInfo) < 2){
                    throw new \Exception("Token empty");
                }

                $jwt = $headerInfo[1];

                $secretKey = Configuration::get('jwtkey');
                $token = JWT::decode($jwt, $secretKey, array('HS512'));
                $tokenData = (array)$token;
            } catch (Exception $ex) {
                throw new \Exception("Token not valid");
            }

            $user = array();
            $userData = json_decode(json_encode($tokenData["data"]),true);
            $user['id'] = $userData["userId"];
            $user['login'] = $userData["userLogin"];
            $user['name'] = $userData["userName"];
            $user['firstname'] = $userData["userFirstname"];
            $user['status_id'] = $userData["userStatus"];

            $newToken = $this->createTocken($user);
            $this->user = $user;
            $this->token = $newToken;
        }
        else{
            throw new \Exception("Token not found");
        }
    }

    public static function createTocken($user)
    {

        $tokenId = base64_encode(mcrypt_create_iv(32));
        $issuedAt = time();
        $notBefore = $issuedAt + 0;             //Adding 10 seconds
        $expire = $notBefore + 30 * 60;            // Adding 60 seconds
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