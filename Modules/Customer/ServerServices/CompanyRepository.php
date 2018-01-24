<?php
namespace Modules\Customer\ServerServices;

class CompanyRepository extends \Mumux\Server\Repository
{

    public function get($id_space)
    {

        $sql = "SELECT * FROM customer_companies WHERE id_space=?";

        $req = $this->runRequest($sql, array($id_space));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        }
        return array();
    }

    public function set($parameters)
    {

        if ($this->exists($parameters["id_space"])) {
            $sql = "UPDATE customer_companies SET name=?, address=?, zipcode=?, city=?, county=?, country=?, phone=?, fax=?, email=?, approval_number=? WHERE id_space=?";
            $this->runRequest($sql, array(
                $parameters["name"],
                $parameters["address"],
                $parameters["zipcode"],
                $parameters["city"],
                $parameters["county"],
                $parameters["country"],
                $parameters["phone"],
                $parameters["fax"],
                $parameters["email"],
                $parameters["approval_number"],
                $parameters["id_space"]
            ));
        } else {
            $sql = "INSERT INTO customer_companies (name, address, zipcode, city, county, country, phone, fax, email, approval_number, id_space) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $this->runRequest($sql, array(
                $parameters["name"],
                $parameters["address"],
                $parameters["zipcode"],
                $parameters["city"],
                $parameters["county"],
                $parameters["country"],
                $parameters["phone"],
                $parameters["fax"],
                $parameters["email"],
                $parameters["approval_number"],
                $parameters["id_space"]
            ));
        }

        return $parameters;

    }

    // internal methods
    public function exists($id_space)
    {
        $sql = "SELECT id FROM customer_companies WHERE id_space=?";
        $req = $this->runRequest($sql, array($id_space));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}