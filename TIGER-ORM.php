<?php

/**
 * TIGER-ORM (Object/Relational Mapping)
 *
 * A beautiful, simple ActiveRecord implementation for working with your database.
 * Each database table has a corresponding "Model" which is used to interact with that table.
 * Models allow you to query for data in your tables, as well as CRUD operations the table.
 *
 *
 * PHP version 5
 *
 *
 * @category   ORM
 * @package    TIGER-ORM
 * @author     Original Author: Ahmed El-Nemr <pro.ahmedelnemr@gmail.com>
 * @copyright  2017-2018 Ahmed El-Nemr
 * @version    $0.1$
 * @link       http:
 */

/*
* Place includes @database_connection_file and use $dbh as instance(object) name
*/

class DatabaseORM
{
    protected $id;
    protected $data;

    /**
     *
     * Initialization object values
     *
     * @param array $data
     * @param optional|string $id
     */
    public function __construct($data, $id="")
    {
        $this->data = $data;
        $this->id = $id;
    }

    /**
     *
     * Prepare Drawing Attributes
     *
     * @return string
     * @internal param array $data
     */
    protected function prepareAttributes ()
    {
        $attrs = "";
        foreach ($this->data as $fieldName => $fieldValue){
            $attrs .= "$fieldName = :$fieldName , ";
        }
        $attrs = rtrim($attrs, ' , ');
        return $attrs;
    }

    /**
     *
     * Prepare Drawing Columns
     *
     * @param $columns
     * @return string
     */
    protected function prepareColumns ($columns)
    {
        if ($columns == "*") return "*";

        $selectColumns = "";
        foreach ($columns as $column){
            $selectColumns .= "$column , ";
        }
        $selectColumns = rtrim($selectColumns, ' , ');
        return $selectColumns;
    }

    /**
     *
     * Insert new record to table
     *
     * @return int @id | bool @fales
     * @internal param $tableName
     * @internal function prepareAttributes()
     *
     */
    public function insert ()
    {
        global $dbh;

        $sql = "INSERT INTO " . static::$tableName . " SET $this->prepareAttributes()";

        $stm = $dbh->prepare($sql);

        return $stm->execute($this->data) ? $dbh->lastInsertId() : false;
    }

    /**
     *
     * Insert new record to table
     *
     * @return bool @true or @fales
     * @internal param $tableName
     * @internal param $id
     * @internal function prepareAttributes()
     *
     */
    public function update()
    {
        global $dbh;

        $sql = "UPDATE " . static::$tableName . " SET $this->prepareAttributes() WHERE id=:id";

        $stm = $dbh->prepare($sql);

        $this->data['id'] = $this->id;

        return $stm->execute($this->data);

    }

    /**
     *
     * Delete record from table
     *
     * @return bool @true or @fales
     * @internal param $tableName
     * @param  param $id
     *
     */
    public static function delete($id)
    {
        global $dbh;

        $sql = "DELETE FROM " . static::$tableName ." WHERE id=:id";

        $stm = $dbh->prepare($sql);

        return $stm->execute([':id'=>$id]);
    }

    /**
     *
     * Find record from table by $id
     *
     * @internal param $tableName
     * @param int $id
     * @param string $columns
     * @return array record or @fales
     */
    public static function find($id, $columns = "*")
    {
        global $dbh;

        $sql = "SELECT " . self::prepareColumns($columns) . " FROM " . static::$tableName ." WHERE id=:id";

        $stm = $dbh->prepare($sql);

        return $stm->execute([':id'=>$id]) ? $sql->fetch(PDO::FETCH_ASSOC) : false;
    }

    /**
     *
     * Select all record from table
     *
     * @internal param $tableName
     * @param string $columns
     * @return array all records or @fales
     */
    public static function all($columns = "*")
    {
        global $dbh;

        $sql = "SELECT " . self::prepareColumns($columns) . " FROM " . static::$tableName;

        $stm = $dbh->prepare($sql);

        return $stm->execute() ? $sql->fetchAll(PDO::FETCH_ASSOC) : false;
    }

}
