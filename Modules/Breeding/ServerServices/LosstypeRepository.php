<?php
namespace Modules\Breeding\ServerServices;

class LosstypeRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space)
    {

        $sql = "SELECT * FROM breeding_losstypes WHERE id_space=?";

        $req = $this->runRequest($sql, array($id_space));
        return $req->fetchAll();
    }

    public function getOne($id_space, $id)
    {

        $sql = "SELECT * FROM breeding_losstypes WHERE id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        }
        return array("name" => "", "id" => 0, "id_space" => $id_space);
    }

    public function set($parameters)
    {

        if ($this->exists($parameters["id"])) {
            $sql = "UPDATE breeding_losstypes SET id_space=?, name=? WHERE id=?";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"],
                $parameters["id"]
            ));
        } else {
            $sql = "INSERT INTO breeding_losstypes (id_space, name) VALUES (?,?)";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"]
            ));
            $parameters["id"] = $this->getLastInsertId();
        }

        return $parameters;

    }

    public function delete($id){
        $sql = "DELETE FROM breeding_losstypes WHERE id=?";
        $this->runRequest($sql, array($id));
    }

    // internal methods
    public function exists($id)
    {
        $sql = "SELECT id FROM breeding_losstypes WHERE id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}