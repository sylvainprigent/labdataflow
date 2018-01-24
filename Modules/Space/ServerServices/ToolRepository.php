<?php
namespace Modules\Space\ServerServices;

class ToolRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space){

        $sql = "SELECT * FROM space_tools WHERE id_space=?";
        return $this->runRequest($sql, array($id_space))->fetchAll();

    }

    public function getOne($id_space, $name_tool){
        $sql = "SELECT * FROM space_tools WHERE id_space=? AND tool=?";
        $req = $this->runRequest($sql, array($id_space, $name_tool));
        if ($req->rowCount() > 0){
            return $req->fetch();
        }
        return array();
        
    }

    public function set($parameters){

        if ($this->exists($parameters["id_space"], $parameters["tool"])) {
            $sql = "UPDATE space_tools SET module=?, name=?, color=?, icon=?, user_role=?, display_order=? WHERE id_space=? AND tool=?";
            $this->runRequest($sql, array(
                $parameters["module"],
                $parameters["name"],
                $parameters["color"],
                $parameters["icon"],
                $parameters["user_role"],
                $parameters["display_order"],
                $parameters["id_space"],
                $parameters["tool"]
            ));
        } else {
            $sql = "INSERT INTO space_tools (module, name, color, icon, user_role, display_order, id_space, tool) VALUES (?,?,?,?,?,?,?,?)";
            $this->runRequest($sql, array(
                $parameters["module"],
                $parameters["name"],
                $parameters["color"],
                $parameters["icon"],
                $parameters["user_role"],
                $parameters["display_order"],
                $parameters["id_space"],
                $parameters["tool"]
            ));
        }

        return $this->getOne($parameters["id_space"], $parameters["tool"]);
    }

    protected function exists($id_space, $toolname){
        $sql = "SELECT * FROM space_tools WHERE id_space=? AND tool=?";
        $req = $this->runRequest($sql, array($id_space, $toolname));
        if ($req->rowCount() > 0){
            return true;
        }
        return false;
    }
}