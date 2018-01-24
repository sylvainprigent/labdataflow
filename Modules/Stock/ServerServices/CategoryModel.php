<?php
namespace Modules\Stock\ServerServices;

class CategoryModel extends \Mumux\Server\Model
{
    public function __construct()
    {
        $this->setTableName("stock_categories");
        
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("name", "varchar(255)", "");
        $this->setColumnsInfo("description", "text", "");
        $this->setColumnsInfo("image_url", "varchar(255)", "");
        $this->setColumnsInfo("origin", "varchar(255)", ""); // module who created the entry

        $this->setPrimaryKey("id");
    }
}