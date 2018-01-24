<?php
namespace Modules\Customer\ServerServices;

class CustomerModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("customer_customers");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("name", "varchar(255)", "");
        $this->setColumnsInfo("contact_name", "varchar(255)", "");
        // delivery address
        $this->setColumnsInfo("delivery_institution", "varchar(255)", "");
        $this->setColumnsInfo("delivery_building_floor", "varchar(255)", "");
        $this->setColumnsInfo("delivery_service", "varchar(255)", "");
        $this->setColumnsInfo("delivery_address", "text", "");
        $this->setColumnsInfo("delivery_zip_code", "varchar(20)", "");
        $this->setColumnsInfo("delivery_city", "varchar(255)", "");
        $this->setColumnsInfo("delivery_country", "varchar(255)", "");
        // invoice address
        $this->setColumnsInfo("invoice_institution", "varchar(255)", "");
        $this->setColumnsInfo("invoice_building_floor", "varchar(255)", "");
        $this->setColumnsInfo("invoice_service", "varchar(255)", "");
        $this->setColumnsInfo("invoice_address", "text", "");
        $this->setColumnsInfo("invoice_zip_code", "varchar(20)", "");
        $this->setColumnsInfo("invoice_city", "varchar(255)", "");
        $this->setColumnsInfo("invoice_country", "varchar(255)", "");
        // contact
        $this->setColumnsInfo("phone", "varchar(20)", "");
        $this->setColumnsInfo("email", "varchar(255)", "");
        $this->setColumnsInfo("pricing", "int(11)", "");
        $this->setColumnsInfo("invoice_send_preference", "int(11)", 0); // 1 email; 2 postal
       
        $this->setPrimaryKey("id");
    }
}