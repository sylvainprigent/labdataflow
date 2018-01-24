<?php
namespace Modules\Customer\ServerServices;

class CompanyModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("customer_companies");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("name", "varchar(255)", "");
        $this->setColumnsInfo("address", "text", "");
        $this->setColumnsInfo("zipcode", "varchar(255)", "");
        $this->setColumnsInfo("city", "varchar(255)", "");
        $this->setColumnsInfo("county", "varchar(255)", "");
        $this->setColumnsInfo("country", "varchar(255)", "");
        $this->setColumnsInfo("phone", "varchar(255)", "");
        $this->setColumnsInfo("fax", "varchar(255)", "");
        $this->setColumnsInfo("email", "varchar(255)", "");
        $this->setColumnsInfo("approval_number", "varchar(255)", "");
       
        $this->setPrimaryKey("id");
    }
}