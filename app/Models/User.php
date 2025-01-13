<?php

class User extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    public function getTable()
    {
        return $this->table;
    }
}
