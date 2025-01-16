<?php

class UserController extends Controller
{
    private $service;

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

  

    public function getUser($dados)
    {
        return $this->service->getUser($dados['userId']);
    }

    public function atualizarUsuario($dados)
    {
        return $this->service->atualizarUsuario($dados);
    }

    public function dashboard()
    {
        $uploadService = new UploadService();
        $documentService = new DocumentoService();
        $uploads = $uploadService->findOne("
        SELECT 
            TO_CHAR(u.created_at::DATE, 'YYYY-MM-DD') AS date,
            COUNT(u.id) AS total_uploads,
            us.name AS user_name
        FROM TABLE_NAME u
        JOIN users us ON u.user_id = us.id
        GROUP BY TO_CHAR(u.created_at::DATE, 'YYYY-MM-DD'), us.name
        ORDER BY date, us.name;        
    ");

        $documents = $documentService->findOne("
        SELECT 
            TO_CHAR(d.created_at::DATE, 'YYYY-MM-DD') AS date,
            COUNT(d.id) AS total_documents,
            us.name AS user_name
        FROM TABLE_NAME d
        JOIN users us ON d.user_id = us.id
        GROUP BY TO_CHAR(d.created_at::DATE, 'YYYY-MM-DD'), us.name
        ORDER BY date, us.name;
    ");

    $body = $this->service->dataTable();
        return $this->render('dashboard', [
            "uploads" => $uploads,
            "documents" => $documents,
            "body" =>  $body,
            "headers" => ["#", 'Criado Em',"Documento ID","Link para Assinar"],
            "keys" => ['id','criado_em','documents_id','actions-dashboard']
        ]);
    }
    
    public function home()
    {
        return $this->render('home');
    }
    
}
