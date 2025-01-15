<?php

class UploadsController extends Controller
{

    private $service;

    public function __construct()
    {
        parent::__construct(true, true);
        $this->service = new UploadService();
    }
    
    public function uploads()
    {

        $dataTable = $this->service->dataTable();
        
        return $this->render('admin/upload', [
            "headers" => ["#", "Arquivo", "Usuário", "Data de Upload"],
            "body" => $dataTable,
            "keys" => ['id', 'filename', 'user_name', 'formatted_created_at']
        ]);
    }

    public function upload()
    {
        return $this->render('admin/create_upload');
    }

    public function uploadStore($dados)
    {
        return $this->service->create($dados);
    }
}
