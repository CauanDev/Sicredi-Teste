<?php

class AdminController extends Controller
{
    private $documentoService;
    private $uploadService;
    private $usersService;

    public function __construct()
    {
        parent::__construct(true, true);
        $this->uploadService = new UploadService();
        $this->documentoService = new DocumentoService();
        $this->usersService = new UserService();
    }

    public function index()
    {
        return $this->render('admin/index');
    }

    public function uploads()
    {

        $dataTable = $this->uploadService->dataTable();

        return $this->render('admin/upload', [
            "headers" => ["#", "Arquivo", "Usuário", "Data de Upload", "Ações"],
            "body" => $dataTable,
            "keys" => ['id', 'filename', 'user_name', 'formatted_created_at', 'actions-index']
        ]);
    }

    public function upload()
    {
        return $this->render('admin/create_upload');
    }

    public function documento()
    {

        
        $uploads = $this->uploadService->getUploads();
        $users = $this->usersService->getPessoas();
        return $this->render('admin/create_documento',[
            "uploads"=>$uploads,
            "users" => $users
        ]);

    }

    public function documentoStore($dados)
    {
        return $this->documentoService->create($dados);
    }

    public function uploadStore($dados)
    {
        return $this->uploadService->create($dados);
    }


}
