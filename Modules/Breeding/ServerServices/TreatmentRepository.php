<?php
namespace Modules\Breeding\ServerServices;

class TreatmentRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space, $id_batch)
    {

        $sql = "SELECT * FROM breeding_treatments WHERE id_batch=?";

        $req = $this->runRequest($sql, array($id_batch));
        return $req->fetchAll();

    }

    public function getOne($id_space, $id_batch, $id)
    {

        $sql = "SELECT * FROM breeding_treatments WHERE id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0){
            return $req->fetch();
        }
        else{
            return array(
                "id" => 0,
                "id_batch" => $id_batch,
                "date" => date("Y-m-d"),
                "antibiotic" => "",
                "suppressor" => "",
                "water" => "",
                "food" => "",
                "comment" => ""
            );
        }

    }

    public function add($id_batch, $parameters){

        $sql = "INSERT INTO breeding_treatments (id_batch, date, antibiotic, suppressor, water, food, comment) VALUES (?,?,?,?,?,?,?)";
        $this->runRequest($sql, array(
            $id_batch,
            $parameters["date"],
            $parameters["antibiotic"],
            $parameters["suppressor"],
            $parameters["water"],
            $parameters["food"],
            $parameters["comment"]
        ));

        $parameters["id_batch"] = $id_batch;
        return $parameters;
    }

    public function set($id_batch, $parameters)
    {
        
        $sql = "UPDATE breeding_treatments SET id_batch=?, date=?, antibiotic=?, suppressor=?, water=?, food=?, comment=? WHERE id=? ";
        $this->runRequest($sql, array(
            $id_batch,
            $parameters["date"],
            $parameters["antibiotic"],
            $parameters["suppressor"],
            $parameters["water"],
            $parameters["food"],
            $parameters["comment"],
            $parameters["id"],
        )); 

        $parameters["id_batch"] = $id_batch;
        return $parameters;
    }

    public function delete($id){

        $sql = "DELETE FROM breeding_treatments WHERE id=?";
        $this->runRequest($sql, array($id));

    }

}