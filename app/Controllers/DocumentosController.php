<?php

class DocumentosController extends Controller
{

    private $service;
    private $uploadService;
    private $usersService;

    public function __construct()
    {        
        parent::__construct(true, true);
        $this->service = new DocumentoService();
        $this->uploadService = new UploadService();
        $this->usersService = new UserService();
    }

    public function documento()
    {
        $uploads = $this->uploadService->getUploads();
        $users = $this->usersService->getPessoas();
        return $this->render('admin/create_documento', [
            "uploads" => $uploads,
            "users" => $users
        ]);
    }

    public function documentoStore($dados)
    {
        return $this->service->create($dados);
    }

    public function index()
    {
        $dataTable = $this->service->dataTable();

        return $this->render('admin/documentos', [
            "headers" => ["#", "Arquivo", "Usuário", "Data de Upload", "ID do Upload", "Qnt de Assinantes", "Ações"," "],
            "body" => $dataTable,
            "keys" => ['id', 'filename', 'username', 'created_at','uploadid','contsigners','actions-documentos']
        ]);
    }

    public function getDocumentos($dados)
    {
        return $this->service->getDocumentos($dados['documentId']);
    }

    public function verificarStatus($dados)
    {
        return $this->service->verificarStatus($dados['documentId']);
    }

    public function verificarAssinatura($dados)
    {
        return $this->service->verificarAssinatura($dados['documentId']);
    }

    public function deleteDocumentos($dados)
    {
        return $this->service->destroy($dados['documentId']);
    }
}
