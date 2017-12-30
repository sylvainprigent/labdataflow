<?php
namespace Modules\Auth\ServerServices;

class UserModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("auth_users");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("login", "varchar(100)", "");
        $this->setColumnsInfo("pwd", "varchar(100)", "");
        $this->setColumnsInfo("name", "varchar(100)", "");
        $this->setColumnsInfo("firstname", "varchar(100)", "");
        $this->setColumnsInfo("email", "varchar(255)", "");
        $this->setColumnsInfo("phone", "varchar(50)", "");
        $this->setColumnsInfo("status_id", "int(2)", 0);
        $this->setColumnsInfo("source", "varchar(30)", "local");
        $this->setColumnsInfo("is_active", "int(1)", 1);
        $this->setColumnsInfo("date_created", "date", "");
        $this->setColumnsInfo("date_end_contract", "date", "");
        $this->setColumnsInfo("date_last_login", "date", "");

        $this->setPrimaryKey("id");
    }
}