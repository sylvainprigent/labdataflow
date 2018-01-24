<?php 

namespace Mumux\Server;

use Mumux\Server\MySqlDatabase;


class Repository
{

    /**
     * Model to manipulate
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    function getLastInsertId(){
        return MySqlDatabase::getDatabase()->lastInsertId();
    }

    function runRequest($request, $params = null)
    {
        if ($params == null) {
            $result = MySqlDatabase::getDatabase()->query($request);
        } else {
            $result = MySqlDatabase::getDatabase()->prepare($request);

            $result->execute($params);
        }
        return $result;
    }


    // interact with the database table
    public function find($orderBy = "", $limit = "", $offset = "")
    {
        $sql = "SELECT * FROM " . $this->model->getTableName() . " ";
        return $this->runRequest($sql)->fetchAll();
    }

    public function findBy(array $query, $orderBy = "", $limit = "", $offset = "")
    {
        $sql = "SELECT * FROM " . $this->model->getTableName() . " WHERE (";
        foreach ($query as $key => $value){
            $sql .= $key . "=" . $value . " AND ";
        }
        $sql .= " 1=1 )";
        $req = $this->runRequest($sql);
        if ($req->rowCount() > 0){
            return $req->fetch();
        }
        return null;
    }

    public function remove(array $query)
    {
        $sql = "DELETE FROM " . $this->model->getTableName() . " WHERE (";
        foreach ($query as $key => $value){
            $sql .= $key . "=" . $value . " AND ";
        }
        $sql .= " 1=1 )";
        $req = $this->runRequest($sql);
    }

    public function insert(array $query)
    {
        $names = "";
        $values = "";
        foreach ($query as $key => $value){
            $names .= $key . ",";
            $values .= $value . ",";
        }
        $sql = "INSERT INTO " . $this->model->getTableName(). " (" . substr($names, 0, -1) . ") VALUES (" . substr($values, 0, -1) . ")";
        $this->runRequest($sql);
    }

    public function update(array $data)
    {
        $values = "";
        $id = 0;
        foreach ($query as $key => $value){

            if ($key == "id"){
                $id = $value;
            }
            else{
                $values .=  $key . "=" . $value . ",";
            }
        }

        $sql = "UPDATE " . $this->model->getTableName() . " SET " . substr($values, 0, -1) . " WHERE id=?";
        $this->runRequest($sql, array($id));
    }

    // create the database table
    public function createTable()
    {
        // create database if not exists

        if ( $this->model->getTableName() != ""){

            $sql = "CREATE TABLE IF NOT EXISTS `" . $this->model->getTableName() . "` (";
            for ($i = 0; $i < $this->model->getColumnsCount() ; $i++) {
                $sql .= "`" . $this->model->getColumnName($i) . "` " . $this->model->getColumnType($i);
                if ($this->model->getColumnDefaultValue($i) != "") {
                    $sql .= " NOT NULL DEFAULT '" . $this->model->getColumnDefaultValue($i) . "' ";
                }
                if ($this->model->getColumnName($i) == $this->model->getPrimaryKey()) {
                    $sql .= " AUTO_INCREMENT ";
                }

                if ($i != $this->model->getColumnsCount() - 1) {
                    $sql .= ", ";
                }
            }
            if ($this->model->getPrimaryKey() != "") {
                $sql .= ", PRIMARY KEY (`" . $this->model->getPrimaryKey() . "`)";
            }
            $sql .= ");";

            $this->runRequest($sql);

            // add columns if added later
            for ($i = 0; $i < $this->model->getColumnsCount() ; $i++) {
                $this->addColumn($this->model->getTableName($i), $this->model->getColumnName($i), $this->model->getColumnType($i), $this->model->getColumnDefaultValue($i));
            }
        }
    }

    /**
     * 
     * @param type $tableName
     * @param type $columnName
     * @param type $columnType
     * @param type $defaultValue
     */
    public function addColumn($tableName, $columnName, $columnType, $defaultValue)
    {

        $sql = "SHOW COLUMNS FROM `" . $tableName . "` LIKE '" . $columnName . "'";
        $pdo = $this->runRequest($sql);
        $isColumn = $pdo->fetch();
        if ($isColumn == false) {
            $sql = "ALTER TABLE `" . $tableName . "` ADD `" . $columnName . "` " . $columnType . " NOT NULL DEFAULT '" . $defaultValue . "'";
            $pdo = $this->runRequest($sql);
        }
    }

}