<?php
namespace Modules\Breeding\ServerServices;

class TreatmentModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->tableName = "breeding_treatments";
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_batch", "int(11)", 0);
        $this->setColumnsInfo("date", "date", "0000-00-00");
        $this->setColumnsInfo("antibiotic", "varchar(255)", "");
        $this->setColumnsInfo("suppressor", "varchar(255)", "");
        $this->setColumnsInfo("water", "varchar(255)", "");
        $this->setColumnsInfo("food", "varchar(255)", "");
        $this->setColumnsInfo("comment", "text", "");
        $this->primaryKey = "id";
    }
}