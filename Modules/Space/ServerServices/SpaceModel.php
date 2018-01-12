<?php
namespace Modules\Space\ServerServices;

class SpaceModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("space_spaces");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("name", "varchar(100)", "");
        $this->setColumnsInfo("status", "int(1)", 1); // 1 public - 0 private
        $this->setColumnsInfo("description", "varchar(255)", "");
        $this->setColumnsInfo("image", "varchar(255)", "");

        $this->setPrimaryKey("id");
    }
}