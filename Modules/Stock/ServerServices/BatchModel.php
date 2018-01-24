<?php
namespace Modules\Stock\ServerServices;

class BatchModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("stock_batches");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("name", "varchar(255)", "");
        $this->setColumnsInfo("created_date", "date", "0000-00-00");
        $this->setColumnsInfo("expiration_date", "date", "0000-00-00");
        $this->setColumnsInfo("initial_quantity", "float", "");
        $this->setColumnsInfo("quantity", "float", 0);
        $this->setColumnsInfo("id_product", "int(11)", 0);
        $this->setColumnsInfo("origin", "varchar(255)", ""); // module who created the entry

        $this->setPrimaryKey("id");
    }
}