<?php
namespace Modules\Breeding\ServerServices;

class BatchModel extends \Mumux\Server\Model
{
    public function __construct()
    {


        // change this with stock_batchs data
        $this->tableName = "breeding_batches";
        $this->setColumnsInfo("id", "int(11)", 0);
        $this->setColumnsInfo("id_stock_batch", "int(11)", 0);
        $this->setColumnsInfo("id_space", "int(11)", 0);
        $this->setColumnsInfo("id_male_spawner", "int(11)", ""); // ref to a batch
        $this->setColumnsInfo("id_female_spawner", "int(11)", ""); // ref to a batch
        $this->setColumnsInfo("id_destination", "int(11)", ""); // 1 sale, 2 Lab
        $this->setColumnsInfo("quantity_losse", "int(11)", 0);
        $this->setColumnsInfo("quantity_sale", "int(11)", 0);
        $this->setColumnsInfo("sexing_female_num", "int(11)", 0);
        $this->setColumnsInfo("sexing_male_num", "int(11)", 0);
        $this->setColumnsInfo("chipped", "int(1)", ""); // 0 vs 1
        $this->setColumnsInfo("comment", "text", "");
        $this->setColumnsInfo("sexing_date", "date", "0000-00-00");
        $this->setColumnsInfo("sexing_f_batch_id", "int(11)", 0);
        $this->setColumnsInfo("sexing_m_batch_id", "int(11)", 0);

        $this->primaryKey = "id";
    }
}