<?php
namespace Modules\Customer\ServerServices;

class PricingRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space)
    {

        $sql = "SELECT * FROM customer_pricings WHERE id_space=?";

        $req = $this->runRequest($sql, array($id_space));
        if ($req->rowCount() > 0) {
            return $req->fetchAll();
        }
        return array();
    }

    public function getOne($id_space, $id_pricing)
    {
        $sql = "SELECT * FROM customer_pricings WHERE id=?";
        $req = $this->runRequest($sql, array($id_pricing));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        } else {
            return array(
                "id" => 0,
                "id_space" => $id_space,
                "name" => ""
            );
        }
    }

    public function set($parameters)
    {

        if ($this->exists($parameters["id"])) {
            $sql = "UPDATE customer_pricings SET id_space=?, name=? WHERE id=?";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"]
            ));
            $id = $parameters["id"];
        } else {
            $sql = "INSERT INTO customer_pricings (id_space, name) VALUES (?,?)";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"]
            ));
            $id = $this->getLastInsertId();
        }

        return array(
            "id" => $id,
            "id_space" => $parameters["id_space"],
            "name" => $parameters["name"]
        );

    }

    public function delete($id_pricing)
    {
        $sql = "DELETE FROM customer_pricings WHERE id=?";
        $this->runRequest($sql, array($id_pricing));
    }

    // internal methods
    public function exists($id_pricing)
    {
        $sql = "SELECT id FROM customer_pricings WHERE id=?";
        $req = $this->runRequest($sql, array($id_pricing));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}