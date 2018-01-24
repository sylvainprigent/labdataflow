<?php
namespace Modules\Breeding\ServerServices;

class LosstypeModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("breeding_losstypes");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("name", "varchar(255)", "");
    
        $this->setPrimaryKey("id");
    }
}