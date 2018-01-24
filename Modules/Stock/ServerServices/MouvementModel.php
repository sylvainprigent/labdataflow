<?php
namespace Modules\Stock\ServerServices;

class MouvementModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("stock_mouvements");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("date", "date", "0000-00-00");
        $this->setColumnsInfo("id_batch", "int(11)", 0);
        $this->setColumnsInfo("quantity", "float", 0);
        $this->setColumnsInfo("type", "int(11)", 0); // -1 output ; +1 input 
        $this->setColumnsInfo("origin", "varchar(255)", ""); // module who created the entry

        $this->setPrimaryKey("id");
    }
}