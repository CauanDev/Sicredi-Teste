<?php

export('Models/User');
export('Services/Service');
class UserService extends Service
{

    public function __construct() {
        parent::__construct(new User());
    }
}