<?php

class AdminController extends Controller
{
    private $usersService;

    public function __construct()
    {
        parent::__construct(true, true);
        $this->usersService = new UserService();
    }

    public function index()
    {
        $users = $this->usersService->getPessoas();

        return $this->render('admin/users', [
            "headers" => ["#", "Nome", "Email", "Data de Criado", ""],
            "body" => $users,
            "keys" => ['id', 'label', 'value', 'criado_em','actions-users']

        ]);
    }

    public function usuario($dados)
    {
        return $this->usersService->getUser($dados['userId']);
    }
    
    public function atualizarUsuario($dados)
    {
        return $this->usersService->atualizarUsuario($dados);
    }

}
