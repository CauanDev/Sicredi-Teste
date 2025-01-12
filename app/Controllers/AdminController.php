<?php

class AdminController extends Controller
{
    private $service;

    public function __construct()
    {
        parent::__construct(true, true);
        $this->service = new DocumentoService();
    }

    public function index()
    {
        return $this->render('admin/index');
    }

    public function uploads()
    {
        return $this->render('admin/upload', [
            "headers" => ["#", "First", "Last", "Handle"],
            "body" => [
                [1, "Mark", "Otto", "@mdo"],
                [2, "Jacob", "Thornton", "@fat"],
                [3, "Larry", "Bird", "@twitter"]
            ]

        ]);
    }

    public function upload()
    {
        return $this->render('admin/create_upload');
    }

    public function store($dados)
    {
        return $this->service->store($dados);
    }
}
