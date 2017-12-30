<?php

namespace Mumux\Server;

/**
 * Abstract class Model
 * A model define a table in the database
 *
 * @author Sylvain Prigent
 */
abstract class Model
{
    /** PDO object of the database 
     */
    protected $tableName;
    private $columnsNames;
    private $columnsTypes;
    private $columnsDefaultValue;
    protected $primaryKey;
    protected $oneToOne;
    protected $manyToOne;
    protected $manyToMany;

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param string primaryKey
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * 
     * @param type $name
     * @param type $type
     * @param type $value
     */
    public function setColumnsInfo($name, $type, $value)
    {
        $this->columnsNames[] = $name;
        $this->columnsTypes[] = $type;
        $this->columnsDefaultValue[] = $value;
    }

    /**
     * @param string $attribute Name of the attribut that point to the linked table id
     * @param string externalTable Name of the linked table
     */
    public function setOneToOne($attribute, $externalTable)
    {
        $this->oneToOne[] = array("attribute" => $attribute, "externalTable" => $externalTable);
    }

    /**
     * @param string $attribute Name of the attribut that point to the linked table id
     * @param string externalTable Name of the linked table
     */
    public function setManyToOne($attribute, $externalTable)
    {
        $this->manyToOne[] = array("attribute" => $attribute, "externalTable" => $externalTable);
    }

    /**
     * @param string $attribute Name of the attribut that point to the linked table id
     * @param string externalTable Name of the linked table
     */
    public function setManyToMany($attribute, $externalTable)
    {
        $this->manyToMany[] = array("attribute" => $attribute, "externalTable" => $externalTable);
    }

    public function getColumnsCount(){
        return count($this->columnsNames);
    }

    public function getTableName(){
        return $this->tableName;
    }
    
    public function getColumnName($i){
        return $this->columnsNames[$i];
    }

    public function getColumnType($i){
        return $this->columnsTypes[$i];
    } 

    public function getColumnDefaultValue($i){
        return $this->columnsDefaultValue[$i];
    }

    public function getPrimaryKey(){
        return $this->primaryKey;
    }

}
