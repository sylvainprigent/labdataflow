<?php
namespace Modules\Space\ServerServices;

class AccessModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("space_accesses");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("id_user", "int(11)", 0);
        $this->setColumnsInfo("id_status", "int(1)", 1); // 1 visitor - 2 user - 3 manager - 4 admin

        $this->setPrimaryKey("id");
    }
}