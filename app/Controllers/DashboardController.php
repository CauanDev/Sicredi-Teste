<?php
export('Controllers/Controller');
session_start();
class DashboardController extends Controller
{
    private $uploadService;
    private $documentService;

    public function __construct()
    {
        parent::__construct(true);
        $this->uploadService = new UploadService();
        $this->documentService = new DocumentoService();
    }

    public function index()
    {

        $uploads = $this->uploadService->findOne("
            SELECT 
                TO_CHAR(u.created_at::DATE, 'YYYY-MM-DD') AS date,
                COUNT(u.id) AS total_uploads,
                us.name AS user_name
            FROM TABLE_NAME u
            JOIN users us ON u.user_id = us.id
            GROUP BY TO_CHAR(u.created_at::DATE, 'YYYY-MM-DD'), us.name
            ORDER BY date, us.name;        
        ");

        $documents = $this->documentService->findOne("
            SELECT 
                TO_CHAR(d.created_at::DATE, 'YYYY-MM-DD') AS date,
                COUNT(d.id) AS total_documents,
                us.name AS user_name
            FROM TABLE_NAME d
            JOIN users us ON d.user_id = us.id
            GROUP BY TO_CHAR(d.created_at::DATE, 'YYYY-MM-DD'), us.name
            ORDER BY date, us.name;
        ");

        return $this->render('dashboard', [
            "uploads" => $uploads,
            "documents" => $documents
        ]);
    }
}
