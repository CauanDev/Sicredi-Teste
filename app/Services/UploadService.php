<?php

class UploadService extends Service
{
    public function __construct()
    {
        parent::__construct(new Upload());
    }

    public function create($dados)
    {
        try {
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

                $fileName = $_FILES['file']['name'];

                if (isset($dados['fileName']) && $dados['fileName']) {
                    $fileName = $dados['fileName'] . '.pdf';
                }

                $fileTmpName = $_FILES['file']['tmp_name'];


                $fileContent = file_get_contents($fileTmpName);

                $fileBytes = base64_encode($fileContent);

                $response = $this->httpRequest(getenv('PORTAL_API_URL') . '/document/upload', 'POST', [
                    "fileName" => $fileName,
                    "bytes" => $fileBytes
                ], [
                    "Token: " . getenv('PORTAL_API_TOKEN')
                ]);

                $uploadID = json_decode($response, true);

                $this->store([
                    'user_id' =>  $_SESSION['user_id'],
                    'upload_id' => $uploadID['uploadId'],
                    "fileName" => $fileName
                ]);

                return json_encode(['sucess' => true, 'message' => 'Arquivo publicado com sucesso, utilize ele em 24 horas']);
            } else {
                return json_encode(['error' => true, 'message' => 'Erro no upload do arquivo ou nenhum arquivo enviado.']);
            }
        } catch (\Exception $e) {
            return json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function dataTable()
    {
        return $this->search("
            SELECT uploads.id, uploads.fileName, users.name AS user_name, 
                TO_CHAR(uploads.created_at, 'DD/MM/YYYY HH24:MI') AS formatted_created_at
            FROM TABLE_NAME
            JOIN users ON uploads.user_id = users.id
        ");
    }

    public function getUploads()
    {
        return $this->search("
        SELECT 
            uploads.upload_id AS id, 
            uploads.fileName AS label, 
            uploads.fileName AS target, 
            uploads.created_at
        FROM TABLE_NAME
        WHERE uploads.created_at >= NOW() - INTERVAL '1 day'
        ");
    }

    public function findOne($sql)
    {
        return $this->search($sql);
    }
}
