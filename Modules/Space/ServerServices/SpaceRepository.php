<?php
namespace Modules\Space\ServerServices;

class SpaceRepository extends \Mumux\Server\Repository
{

    public function selectAll()
    {
        $sql = "SELECT * FROM space_spaces";
        $req = $this->runRequest($sql);
        if ($req->rowCount() > 0) {
            return $req->fetchAll();
        }
        return null;
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM space_spaces WHERE id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        }
        return null;
    }

    public function add($parameters)
    {

        // insert in auth table
        $sql = "INSERT INTO space_spaces ( name, status ) VALUES ( ?, ? )";
        $this->runRequest($sql, array(
            $parameters["name"],
            $parameters["status"]
        ));
    }

    public function edit($id, $parameters){
    
    }

}