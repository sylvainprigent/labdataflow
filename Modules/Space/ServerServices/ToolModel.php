<?php
namespace Modules\Space\ServerServices;

class ToolModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("space_tools");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("module", "varchar(255)", "");
        $this->setColumnsInfo("tool", "varchar(255)", ""); 
        $this->setColumnsInfo("name", "varchar(255)", ""); 
        $this->setColumnsInfo("icon", "varchar(255)", "");
        $this->setColumnsInfo("color", "varchar(7)", "#e1e1e1");
        $this->setColumnsInfo("user_role", "int(1)", 0);
        $this->setColumnsInfo("display_order", "int(11)", 0);

        $this->setPrimaryKey("id");
    }
}
