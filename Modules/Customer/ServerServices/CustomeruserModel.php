<?php
namespace Modules\Customer\ServerServices;

class CustomeruserModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("customer_j_customer_user");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_customer", "int(11)", 0);
        $this->setColumnsInfo("id_user", "int(11)", 0);
       
        $this->setPrimaryKey("id");
    }
}