<?php

export('Controllers/Controller');
export('Models/User');
export('Services/UserService');

class UserController extends Controller
{
    protected $service;


    public function __construct()
    {
        $this->service = new UserService();
    }

    public function index()
    {
        return $this->render('usuario/login');
    }

    public function register()
    {
        return $this->render('usuario/register');
    }

    public function login($dados)
    {
        return $this->service->login($dados);
    }

    public function store($dados)
    {
        return $this->service->create($dados);
    }

}
