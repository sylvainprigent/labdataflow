<?php
namespace Modules\Customer\ServerServices;

class CustomerRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space)
    {

        $sql = "SELECT customer_customers.*, customer_pricings.name as pricingname ";
        $sql .= "FROM customer_customers ";
        $sql .= "INNER JOIN customer_pricings ON customer_customers.pricing = customer_pricings.id ";
        $sql .= "WHERE customer_customers.id_space=?";

        $req = $this->runRequest($sql, array($id_space));
        if ($req->rowCount() > 0) {
            return $req->fetchAll();
        }
        return array();
    }

    public function getOne($id_space, $id_customer)
    {
        $sql = "SELECT * FROM customer_customers WHERE id=?";
        $req = $this->runRequest($sql, array($id_customer));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        } else {
            return array(
                "id" => 0,
                "id_space" => $id_space,
                "name" => "",
                "contact_name" => "",
                "delivery_institution" => "",
                "delivery_building_floor" => "",
                "delivery_service" => "",
                "delivery_address" => "",
                "delivery_zip_code" => "",
                "delivery_city" => "",
                "delivery_country" => "",
                "invoice_institution" => "",
                "invoice_building_floor" => "",
                "invoice_service" => "",
                "invoice_address" => "",
                "invoice_zip_code" => "",
                "invoice_city" => "",
                "invoice_country" => "",
                "phone" => "",
                "email" => "",
                "pricing" => 0,
                "invoice_send_preference" => "",
            );
        }
    }

    public function set($parameters)
    {

        if ($this->exists($parameters["id"])) {
            $sql = "UPDATE customer_customers SET id_space=?, name=?, contact_name=?, delivery_institution=?, ";
            $sql .= "        delivery_building_floor=?, delivery_service=?, delivery_address=?, delivery_zip_code=?, ";
            $sql .= "        delivery_city=?, delivery_country=?, invoice_institution=?, invoice_building_floor=?, ";
            $sql .= "        invoice_service=?, invoice_address=?, invoice_zip_code=?, invoice_city=?, ";
            $sql .= "        invoice_country=?, phone=?, email=?, pricing=?, invoice_send_preference=? ";      
            $sql .= "         WHERE id=?";
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"],
                $parameters["contact_name"],
                $parameters["delivery_institution"],
                $parameters["delivery_building_floor"],
                $parameters["delivery_service"],
                $parameters["delivery_address"],
                $parameters["delivery_zip_code"],
                $parameters["delivery_city"],
                $parameters["delivery_country"],
                $parameters["invoice_institution"],
                $parameters["invoice_building_floor"],
                $parameters["invoice_service"],
                $parameters["invoice_address"],
                $parameters["invoice_zip_code"],
                $parameters["invoice_city"],
                $parameters["invoice_country"],
                $parameters["phone"],
                $parameters["email"],
                $parameters["pricing"],
                $parameters["invoice_send_preference"],
                $parameters["id"]
            ));
            $id = $parameters["id"];
        } else {
            $sql = "INSERT INTO customer_customers (id_space, name, contact_name, delivery_institution, ";
            $sql .= "delivery_building_floor, delivery_service, delivery_address, delivery_zip_code, ";
            $sql .= "delivery_city, delivery_country, invoice_institution, invoice_building_floor, ";
            $sql .= "invoice_service, invoice_address, invoice_zip_code, invoice_city, ";
            $sql .= "invoice_country, phone, email, pricing, invoice_send_preference) ";
            $sql .= "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            
            $this->runRequest($sql, array(
                $parameters["id_space"],
                $parameters["name"],
                $parameters["contact_name"],
                $parameters["delivery_institution"],
                $parameters["delivery_building_floor"],
                $parameters["delivery_service"],
                $parameters["delivery_address"],
                $parameters["delivery_zip_code"],
                $parameters["delivery_city"],
                $parameters["delivery_country"],
                $parameters["invoice_institution"],
                $parameters["invoice_building_floor"],
                $parameters["invoice_service"],
                $parameters["invoice_address"],
                $parameters["invoice_zip_code"],
                $parameters["invoice_city"],
                $parameters["invoice_country"],
                $parameters["phone"],
                $parameters["email"],
                $parameters["pricing"],
                $parameters["invoice_send_preference"]
            ));
            $id = $this->getLastInsertId();
        }

        $parameters["id"] = $id;
        return $parameters;

    }

    public function delete($id)
    {
        $sql = "DELETE FROM customer_customers WHERE id=?";
        $this->runRequest($sql, array($id));
    }

    // internal methods
    public function exists($id)
    {
        $sql = "SELECT id FROM customer_customers WHERE id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return true;
        }
        return false;
    }
}