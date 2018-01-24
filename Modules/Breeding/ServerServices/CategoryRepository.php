<?php
namespace Modules\Breeding\ServerServices;

class CategoryRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space)
    {

        $sql = "SELECT * FROM stock_categories WHERE id_space=? AND origin=?";

        $req = $this->runRequest($sql, array($id_space, "breeding"));
        return $req->fetchAll();
    }

    public function getOne($id_space, $id)
    {

        $sql = "SELECT * FROM stock_categories WHERE id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        }
        return array(
            "id" => 0, 
            "id_space" => $id_space,
            "name" => "",
            "description" => "",
            "image_url" => "",
            "origin" => "breeding"
        );
    }

    public function set($parameters)
    {

        $parameters["origin"] = "breeding";
        if ($this->exists($parameters["id"])) {
            $sql = "UPDATE stock_categories SET id_space=?, name=?, description=?, origin=? WHERE id=?";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"],
                $parameters["description"],
                $parameters["origin"],
                $parameters["id"]
            ));
        } else {
            $sql = "INSERT INTO stock_categories (id_space, name, description, origin) VALUES (?,?,?,?)";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"],
                $parameters["description"],
                $parameters["origin"]
            ));
            $parameters["id"] = $this->getLastInsertId();
        }

        return $parameters;

    }

    public function delete($id){
        $sql = "DELETE FROM stock_categories WHERE id=?";
        $this->runRequest($sql, array($id));
    }

    // internal methods
    public function exists($id)
    {
        $sql = "SELECT id FROM stock_categories WHERE id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}