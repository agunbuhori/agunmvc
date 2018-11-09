<?php

namespace Libraries\Database;

use PDO;

const SELECT_QUERY = "SELECT %s FROM %s %s %s";
const JOIN_QUERY = "%s JOIN %s";
const UPDATE_QUERY = "UPDATE %s SET %s";
const INSERT_QUERY = "INSERT INTO %s(%s) VALUES(%s)";
const DELETE_QUERY = "UPDATE %s SET %s";
const WHERE_QUERY = " WHERE %s";
const LIMIT_QUERY = " LIMIT %s";

class QueryBuilder extends PDO
{
    private $pdo;
    private $selectedTable;
    private $columns = '*';
    private $query;
    private $where;
    private $limit;
    private $data;

    public function getConnection()
    {
        $config = require_once(PATH.'config/database.php');
        $dbConfig = $config[env('provider', 'mysql')];

        parent::__construct("{$config['provider']}:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
            $dbConfig['username'], 
            $dbConfig['password']
        );
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $this;
    }

    /**
     * Set active table
     * 
     * @return void
     */
    public function table($table)
    {
        $this->selectedTable = $table;

        return $this;
    }

    /**
     * Select custom columns
     * 
     * @return void
     */
    public function select()
    {
        $this->columns = implode(', ', func_get_args());

        return $this;
    }

    /**
     * Get all rows from table
     * 
     * @return array
     */
    public function getAll()
    {
        if (is_null($this->query))
            $this->query = sprintf(SELECT_QUERY, $this->columns, $this->selectedTable, $this->where, $this->limit);

        $statement = parent::prepare($this->query);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Get by primary
     * 
     * @return void
     */
    public function getByPrimary($value, $column = 'id')
    {
        if (is_null($this->query))
            $this->query = sprintf(SELECT_QUERY, $this->columns, $this->selectedTable, $this->where, $this->limit)." WHERE {$column} = :value";
        
        $statement = parent::prepare($this->query);
        $statement->execute([':value' => $value]);

        return $statement->fetch();
    }

    /**
     * Insert data to table
     * 
     * @return void
     */
    public function insert($data)
    {
        $cols = [];
        $new_data = [];

        foreach ($data as $key => $value) {
            $cols[] = "{$key}";
            $new_data[":{$key}"] = $value;
        }

        $statement = parent::prepare(
            sprintf(INSERT_QUERY, $this->selectedTable, implode(', ', $cols), implode(', ', array_keys($new_data)))
        );
        $statement->execute($new_data);

        return $this->getByPrimary(parent::lastInsertId());
    }

    /**
     * Update query
     * 
     * @return void
     */
    public function update($data)
    {

    }

    /**
     * Destroy connection
     * 
     * @return void
     */
    public function __destruct()
    {
        $this->pdo = null;
    }
    
}