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
        var_dump($dados);
    }

    public function create($dados)
    {
        // Verificar se os campos necessários estão presentes
        if (isset($dados['email'], $dados['email_confirm'], $dados['password'], $dados['name'])) {
            // Verificar se os e-mails coincidem
            if ($dados['email'] === $dados['email_confirm']) {
                // Chama o serviço para criar o usuário
                $this->service->create([
                    'email' => $dados['email'],
                    'password' => $dados['password'],
                    'name' => $dados['name']
                ]);
                header("Location: /success"); // Redirecionar para uma página de sucesso
                exit;
            } else {
                // Caso os e-mails não coincidam, armazenar na sessão
                $error = "Os e-mails não coincidem!";
                return $this->render('usuario/register', ['error' => $error]);                exit;
            }
        } else {
            // Caso faltem campos obrigatórios, armazenar na sessão
            $error = "Campos obrigatórios estão faltando!";
            return $this->render('usuario/register', ['error' => $error]);
        }
    }
    
    
}
