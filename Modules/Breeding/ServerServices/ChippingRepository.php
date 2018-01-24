<?php
namespace Modules\Breeding\ServerServices;

class ChippingRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space, $id_batch)
    {

        $sql = "SELECT * FROM breeding_chipping WHERE id_batch=?";

        $req = $this->runRequest($sql, array($id_batch));
        return $req->fetchAll();

    }

    public function getOne($id_space, $id_batch, $id)
    {

        $sql = "SELECT * FROM breeding_chipping WHERE id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0){
            return $req->fetch();
        }
        else{
            return array(
                "id" => 0,
                "id_batch" => $id_batch,
                "date" => date("Y-m-d"),
                "chip_number" => "",
                "comment" => ""
            );
        }

    }

    public function add($id_batch, $parameters){

        $sql = "INSERT INTO breeding_chipping (id_batch, date, chip_number, comment) VALUES (?,?,?,?)";
        $this->runRequest($sql, array(
            $id_batch,
            $parameters["date"],
            $parameters["chip_number"],
            $parameters["comment"]
        ));

        $parameters["id_batch"] = $id_batch;
        return $parameters;
    }

    public function set($id_batch, $parameters)
    {
        
        $sql = "UPDATE breeding_chipping SET id_batch=?, date=?, chip_number=?, comment=? WHERE id=? ";
        $this->runRequest($sql, array(
            $id_batch,
            $parameters["date"],
            $parameters["chip_number"],
            $parameters["comment"],
            $parameters["id"],
        )); 

        $parameters["id_batch"] = $id_batch;
        return $parameters;
    }

    public function delete($id){

        $sql = "DELETE FROM breeding_chipping WHERE id=?";
        $this->runRequest($sql, array($id));

    }

}