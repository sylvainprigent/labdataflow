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

    public function getByLogin($login){

        $sql = "SELECT id, name, firstname, status_id FROM auth_users WHERE login=?";
        $req = $this->runRequest($sql, array($login));
        if ($req->rowCount() > 0){
            return $req->fetch();
        }
        return null;
    }

    public function createDefaultUser(){


        $login = "admin";
        $password = "admin";
        $status_id = 2;
        $date_created = date("Y-m-d", time()); 

        $sql = "INSERT INTO auth_users (login, pwd, status_id, date_created) VALUES (?,?,?,?)";
        $this->runRequest($sql, array(
            $login,
            md5($password),
            $status_id,
            $date_created
        ));

    }
}