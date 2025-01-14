<?php

class DocumentosController extends Controller
{

    private $service;
    private $uploadService;
    private $usersService;
    
    public function __construct()
    {
        $this->service = new DocumentoService();
        $this->uploadService = new UploadService();
        $this->usersService = new UserService();

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
        return $this->service->create($dados);
    }
}
