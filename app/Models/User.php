<?php

export('Models/Model');

class User extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }
}
