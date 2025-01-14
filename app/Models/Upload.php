<?php

class Upload extends Model
{

    protected $table = 'uploads';

    public function __construct()
    {
        parent::__construct($this->table);
    }


}
