<?php

namespace Libraries\Model;

use Libraries\Database\QueryBuilder;

class Model extends QueryBuilder
{
    /**
     * Set table from constructor
     * 
     * @return void
     */
    public function __construct()
    {
        parent::getConnection();

        $childClassName = 'user';
        $table = isset($this->table) ? $this->table : pluralize(strtolower($childClassName));

        parent::table($table);
    }

    /**
     * Get find by id
     * 
     * @return object
     */
    public function find($id)
    {
        return parent::getByPrimary($id);
    }

    /**
     * Return response error if data not found
     * 
     * @return array
     */
    public function findOrFail($id)
    {
        $result = $this->find($id);
        

        if (! $result) {
            return ["error" => 404, "message" => "Not found"];
        }

        return $result;
    }
}