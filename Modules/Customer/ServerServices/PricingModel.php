<?php
namespace Modules\Customer\ServerServices;

class PricingModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("customer_pricings");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("name", "varchar(255)", "");

        $this->setPrimaryKey("id");
    }
}