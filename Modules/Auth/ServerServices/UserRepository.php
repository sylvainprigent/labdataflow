<?php
namespace Modules\Auth\ServerServices;

class UserRepository extends \Mumux\Server\Repository
{

    public function login($login, $password){

        $sql = "SELECT * FROM auth_users WHERE login=? AND pwd=?";
        $req = $this->runRequest($sql, array($login, md5($password)));
        if ($req->rowCount() > 0){
            return $req->fetch();
        }
        return null;
    }
}