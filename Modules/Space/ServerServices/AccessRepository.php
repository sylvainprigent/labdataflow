<?php
namespace Modules\Space\ServerServices;

class AccessRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space)
    {

        $sql = "SELECT auth_users.name, auth_users.firstname, auth_users.email, "
            . " space_accesses.id_status as space_status, space_accesses.id_user as id_user, "
            . " space_accesses.id as id "
            . " FROM space_accesses "
            . " INNER JOIN auth_users ON space_accesses.id_user = auth_users.id "
            . " WHERE space_accesses.id_space=?";

        $req = $this->runRequest($sql, array($id_space));
        if ($req->rowCount() > 0) {
            $data = $req->fetchAll();
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]["status"] = $this->getStatusName($data[$i]["space_status"]);
            }
            return $data;
        }
        return array();
    }

    public function getOne($id_space, $id_access)
    {
        $sql = "SELECT * FROM space_accesses WHERE id=?";
        $req = $this->runRequest($sql, array($id_access));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        } else {
            return array(
                "id" => 0,
                "id_space" => $id_space,
                "id_user" => 0,
                "id_status" => 2
            );
        }
    }

    public function set($parameters)
    {

        if ($this->exists($parameters["id"])) {
            $sql = "UPDATE space_accesses SET id_space=?, id_user=?, id_status=? WHERE id=?";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["id_user"],
                $parameters["id_status"],
                $parameters["id"],
            ));
            $id = $parameters["id"];
        } else {
            $sql = "INSERT INTO space_accesses (id_space, id_user, id_status) VALUES (?,?,?)";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["id_user"],
                $parameters["id_status"]
            ));
            $id = $this->getLastInsertId();
        }


        $sqlu = "SELECT name, firstname FROM auth_users WHERE id=?";
        $user = $this->runRequest($sqlu, array($parameters["id_user"]))->fetch();

        return array(
            "id" => $id,
            "id_space" => $parameters["id_space"],
            "id_user" => $parameters["id_user"],
            "id_status" => $parameters["id_status"],
            "name" => $user["name"],
            "firstname" => $user["firstname"],
            "status" => $this->getStatusName($parameters["id_status"])
        );


    }

    public function delete($id_access)
    {
        $sql = "DELETE FROM space_accesses WHERE id=?";
        $this->runRequest($sql, array($id_access));
    }

    // internal methods
    protected function getStatusName($id_status)
    {
        if ($id_status == 1) {
            return "Visitor";
        } else if ($id_status == 2) {
            return "User";
        } else if ($id_status == 3) {
            return "Manager";
        } else if ($id_status == 4) {
            return "Admin";
        }
    }

    public function exists($id_access)
    {
        $sql = "SELECT id FROM space_accesses WHERE id=?";
        $req = $this->runRequest($sql, array($id_access));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}