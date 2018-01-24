<?php
namespace Modules\Breeding\ServerServices;

class ProductRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space)
    {

        $sql = "SELECT stock_products.*, stock_categories.name as category ";
        $sql .= "FROM stock_products ";
        $sql .= "INNER JOIN stock_categories ON stock_products.id_category = stock_categories.id ";
        $sql .= "WHERE stock_products.id_space=? AND stock_products.origin=?";

        $req = $this->runRequest($sql, array($id_space, "breeding"));
        return $req->fetchAll();
    }

    public function getOne($id_space, $id)
    {

        $sql = "SELECT * FROM stock_products WHERE id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        }
        return array(
            "id" => 0, 
            "id_space" => $id_space,
            "name" => "",
            "id_category" => 0,
            "description" => "",
            "image_url" => "",
            "origin" => "breeding"
        );
    }

    public function set($parameters)
    {

        // add here image upload

        $parameters["origin"] = "breeding";
        if ($this->exists($parameters["id"])) {
            $sql = "UPDATE stock_products SET id_space=?, name=?, id_category=?, description=?, origin=? WHERE id=?";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"],
                $parameters["id_category"],
                $parameters["description"],
                $parameters["origin"],
                $parameters["id"]
            ));
        } else {
            $sql = "INSERT INTO stock_products (id_space, name, id_category, description, origin) VALUES (?,?,?,?,?)";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"],
                $parameters["id_category"],
                $parameters["description"],
                $parameters["origin"]
            ));
            $parameters["id"] = $this->getLastInsertId();
        }

        return $parameters;

    }

    public function delete($id){
        $sql = "DELETE FROM stock_products WHERE id=?";
        $this->runRequest($sql, array($id));
    }

    // internal methods
    public function exists($id)
    {
        $sql = "SELECT id FROM stock_products WHERE id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}