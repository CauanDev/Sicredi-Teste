<?php

class DocumentoService extends Service
{
    public function __construct()
    {
        parent::__construct(new Documento());
    }

    public function store($dados)
    {
        try {
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

                $fileName = $_FILES['file']['name'];

                if(isset($dados['fileName'])){
                    $fileName = $dados['fileName'].'.pdf';
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
                    'upload_id' => $uploadID['uploadId']
                ]);

                return json_encode(['sucess' => true, 'message' => 'Arquivo publicado com sucesso, utilize ele em 24 horas']);
            } else {
                return json_encode(['error' => true, 'message' => 'Erro no upload do arquivo ou nenhum arquivo enviado.']);
            }
        } catch (\Exception $e) {
            return json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
