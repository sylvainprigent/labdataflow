<?php
namespace Modules\Breeding\ServerServices;

class ChippingModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->tableName = "breeding_chipping";
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_batch", "int(11)", 0);
        $this->setColumnsInfo("date", "date", "0000-00-00");
        $this->setColumnsInfo("chip_number", "varchar(255)", "");
        $this->setColumnsInfo("comment", "text", "");
        $this->primaryKey = "id";
    }
}