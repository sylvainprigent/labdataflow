<?php
namespace Modules\Breeding\ServerServices;

class LossModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->tableName = "breeding_losses";
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("id_user", "int(11)", "");
        $this->setColumnsInfo("comment", "text", "");
        $this->setColumnsInfo("id_type", "text", "");
        $this->setColumnsInfo("id_stock_move", "int(11)", "");

        $this->primaryKey = "id";
    }
}