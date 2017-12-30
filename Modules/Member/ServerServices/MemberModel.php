<?php
namespace Modules\Member\ServerServices;

class MemberModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("member_users");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("avatar", "varchar(100)", "");
        $this->setColumnsInfo("title", "varchar(255)", "");
        $this->setColumnsInfo("position", "varchar(255)", "");
        $this->setColumnsInfo("institution", "varchar(255)", "");
        $this->setColumnsInfo("location", "varchar(255)", "");
        $this->setColumnsInfo("summary", "text", "");

        $this->setPrimaryKey("id");
    }
}