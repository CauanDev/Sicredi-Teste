<?php

class Signers extends Model
{

    protected $table = 'signers';

    public function __construct()
    {
        parent::__construct($this->table);
    }


    

}
