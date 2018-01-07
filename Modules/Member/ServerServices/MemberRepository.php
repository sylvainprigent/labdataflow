<?php
namespace Modules\Member\ServerServices;

class MemberRepository extends \Mumux\Server\Repository
{

    public function selectAll()
    {

        $sql = "SELECT auth_users.id, auth_users.login, auth_users.status_id, auth_users.source, "
            . " auth_users.name, auth_users.firstname, auth_users.email, auth_users.date_last_login, "
            . " auth_users.date_created, auth_users.phone, member_users.avatar, member_users.title, "
            . " member_users.position, member_users.institution, member_users.location, "
            . " member_users.summary "
            . "FROM auth_users "
            . "INNER JOIN member_users ON auth_users.id = member_users.id";

        $req = $this->runRequest($sql);
        if ($req->rowCount() > 0) {
            return $req->fetchAll();
        }
        return null;
    }

    public function selectFilter($filter)
    {

        $sql = "SELECT auth_users.id, auth_users.login, auth_users.status_id, auth_users.source, "
            . " auth_users.name, auth_users.firstname, auth_users.email, auth_users.date_last_login, "
            . " auth_users.date_created, auth_users.phone, member_users.avatar, member_users.title, "
            . " member_users.position, member_users.institution, member_users.location, "
            . " member_users.summary "
            . "FROM auth_users "
            . "INNER JOIN member_users ON auth_users.id = member_users.id ";
            

        if ($filter != "all") {
            $sql .= " WHERE auth_users.name LIKE '" . $filter . "%' ";
        }
        $sql .= "ORDER BY auth_users.name ASC ";

        //echo $sql;
        $req = $this->runRequest($sql);
        if ($req->rowCount() > 0) {
            return $req->fetchAll();
        }
        return null;
    }

    public function getOne($id)
    {
        $sql = "SELECT auth_users.id, auth_users.login, auth_users.status_id, auth_users.source, "
            . " auth_users.date_end_contract, "
            . " auth_users.name, auth_users.firstname, auth_users.email, auth_users.date_last_login, "
            . " auth_users.date_created, auth_users.phone, member_users.avatar, member_users.title, "
            . " member_users.position, member_users.institution, member_users.location, "
            . " member_users.summary "
            . " FROM auth_users "
            . " INNER JOIN member_users ON auth_users.id = member_users.id "
            . " WHERE auth_users.id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        }
        return null;
    }

    public function add($parameters)
    {

        // insert in auth table
        $sql = "INSERT INTO auth_users (login, pwd, name, firstname, email, "
            . " status_id, date_created, date_end_contract, phone) VALUES ( ?,?,?,?,?,?,?,?,? )";
        $this->runRequest($sql, array(
            $parameters["login"],
            md5($parameters["password"]),
            $parameters["name"],
            $parameters["firstname"],
            $parameters["email"],
            $parameters["status_id"],
            date("Y-m-d", time()),
            $parameters["date_end_contract"],
            $parameters["phone"]
        ));

        $id = $this->getLastInsertId();

        // insert in member table
        $sql2 = "INSERT INTO member_users (id, avatar, title, position, institution, location, summary) VALUES (?,?,?,?,?,?,?)";
        $this->runRequest($sql2, array(
            $id,
            "",
            "",
            "",
            "",
            "",
            "",
        ));

    }

    public function put($id, $parameters){
        
        // insert in auth table
        $sql = "UPDATE auth_users SET login=?, name=?, firstname=?, email=?, "
            . " status_id=?, date_created=?, date_end_contract=?, phone=? WHERE id=?";
        $this->runRequest($sql, array(
            $parameters["login"],
            $parameters["name"],
            $parameters["firstname"],
            $parameters["email"],
            $parameters["status_id"],
            date("Y-m-d", time()),
            $parameters["date_end_contract"],
            $parameters["phone"],
            $id
        ));
    }



    public function exists($login)
    {

        $sql = "SELECT id FROM auth_users WHERE login=?";
        $req = $this->runRequest($sql, array($login));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}