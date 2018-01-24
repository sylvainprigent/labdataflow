<?php
namespace Modules\Breeding\ServerServices;

class LossRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space, $id_batch)
    {

        $sql = "SELECT stock_mouvements.*, breeding_losses.*, breeding_losstypes.name as typename ";
        $sql .= "FROM breeding_losses ";
        $sql .= "INNER JOIN stock_mouvements ON breeding_losses.id_stock_move = stock_mouvements.id ";
        $sql .= "INNER JOIN breeding_losstypes ON breeding_losses.id_type = breeding_losstypes.id ";
        $sql .= "WHERE stock_mouvements.id_batch=?";

        $req = $this->runRequest($sql, array($id_batch));
        return $req->fetchAll();

    }

    public function getOne($id_space, $id_batch, $id)
    {

        $sql = "SELECT stock_mouvements.*, breeding_losses.* ";
        $sql .= "FROM breeding_losses ";
        $sql .= "INNER JOIN stock_mouvements ON breeding_losses.id_stock_move = stock_mouvements.id ";
        $sql .= "WHERE breeding_losses.id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0){
            return $req->fetch();
        }
        else{
            return array(
                "id" => 0,
                "id_space" => $id_space,
                "id_batch" => $id_batch,
                "comment" => "",
                "id_type" => "",
                "date" => date("Y-m-d"),
                "quantity" => 0
            );
        }

    }

    public function add($id_user, $id_batch, $parameters){

        $sql = "INSERT INTO stock_mouvements (date, id_batch, quantity, type, origin) VALUES (?,?,?,?,?)";
        $this->runRequest($sql, array(
            $parameters["date"],
            $id_batch,
            $parameters["quantity"],
            -1,
            "breeding"
        ));
        $id_stock = $this->getLastInsertId();

        $sql2 = "INSERT INTO breeding_losses (id_space, id_user, comment, id_type, id_stock_move) VALUES (?,?,?,?,?)";
        $this->runRequest($sql2, array(
            $parameters["id_space"],
            $id_user, 
            $parameters["comment"],
            $parameters["id_type"],
            $id_stock
        ));

        $parameters["id"] = $this->getLastInsertId();
        $parameters["id_stock_move"] = $id_stock;


        $sql3 = "SELECT name FROM breeding_losstypes WHERE id=?";
        $typeName = $this->runRequest($sql3, array($parameters["id_type"]))->fetch(); 
        $parameters["typename"] = $typeName[0];

        return $parameters;
    }

    public function set($id_user, $id_batch, $parameters)
    {
        
        $sql1 = "SELECT id_stock_move FROM breeding_losses WHERE id=?";
        $id_stock = $this->runRequest($sql1, array($parameters["id"]))->fetch();
        $id_stock = $id_stock[0];

        $sql = "UPDATE stock_mouvements SET date=?, id_batch=?, quantity=?, type=?, origin=? WHERE id=?";
        $this->runRequest($sql, array(
            $parameters["date"],
            $id_batch,
            $parameters["quantity"],
            -1,
            "breeding",
            $id_stock
        ));


        $sql2 = "UPDATE breeding_losses SET id_space=?, id_user=?, comment=?, id_type=?, id_stock_move=? WHERE id=? ";
        $this->runRequest($sql2, array(
            $parameters["id_space"],
            $id_user,
            $parameters["comment"],
            $parameters["id_type"],
            $id_stock,
            $parameters["id"]
        )); 

        //print_r( $parameters );
        return $parameters;
    }

    public function delete($id){

        $sql1 = "SELECT id_stock_move FROM breeding_losses WHERE id=?";
        $id_stock = $this->runRequest($sql1, array($id))->fetch();

        $sql = "DELETE FROM stock_mouvements WHERE id=?";
        $this->runRequest($sql, array($id_stock));

        $sql2 = "DELETE FROM breeding_losses WHERE id=?";
        $this->runRequest($sql, array($id));
    }

}