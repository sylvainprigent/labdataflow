<?php
namespace Modules\Customer\ServerServices;

class CustomeruserRepository extends \Mumux\Server\Repository
{

    public function getAll($id_customer)
    {

        $sql = "SELECT customer_j_customer_user.id as id, customer_j_customer_user.id_user as id_user, customer_j_customer_user.id_customer as id_customer, ";
        $sql .= "auth_users.name as name, auth_users.firstname as firstname ";
        $sql .= "FROM customer_j_customer_user ";
        $sql .= "INNER JOIN auth_users ON customer_j_customer_user.id_user = auth_users.id ";
        $sql .= "WHERE customer_j_customer_user.id_customer=?";

        $req = $this->runRequest($sql, array($id_customer));
        if ($req->rowCount() > 0) {
            return $req->fetchAll();
        }
        return array();
    }

    public function getOne($id_customer, $id)
    {
        $sql = "SELECT * FROM customer_j_customer_user WHERE id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        } else {
            return array(
                "id" => 0,
                "id_customer" => $id_customer,
                "id_user" => 0,
            );
        }
    }

    public function set($parameters)
    {

        if ( ! $this->exists($parameters["id"]) ) {
            $sql = "INSERT INTO customer_j_customer_user (id_customer, id_user) ";
            $sql .= "VALUES (?,?)";
            
            $this->runRequest($sql, array(
                $parameters["id_customer"], 
                $parameters["id_user"]
            ));
            $id = $this->getLastInsertId();
        }
        else{
            $sql = "UPDATE customer_j_customer_user SET id_customer=?, id_user=? WHERE id=?";
            $this->runRequest($sql, array(
                $parameters["id_customer"], 
                $parameters["id_user"],
                $parameters["id"]
            ));
            
        }

        $sqlu = "SELECT name, firstname FROM auth_users WHERE id=?";
        $user = $this->runRequest($sqlu, array($parameters["id_user"]))->fetch(); 

        return array("id" => $id, "name" => $user["name"], "firstname" => $user["firstname"], "id_customer" => $parameters["id_customer"], "id_user" => $parameters["id_user"]);

    }

    public function delete($id)
    {
        $sql = "DELETE FROM customer_j_customer_user WHERE id=?";
        $this->runRequest($sql, array($id));
    }

    // internal methods
    public function exists($id)
    {
        $sql = "SELECT id FROM customer_j_customer_user WHERE id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}