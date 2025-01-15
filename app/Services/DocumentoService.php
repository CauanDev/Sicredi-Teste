<?php

class DocumentoService extends Service
{
    private $uploadService;
    private $signersService;

    public function __construct()
    {
        parent::__construct(new Documento());
        $this->uploadService = new UploadService();
        $this->signersService = new SignersService();
    }

    public function dataTable()
    {
        return $this->uploadService->findOne("
            SELECT 
                u.fileName AS fileName,
                us.name AS userName,
                TO_CHAR(u.created_at, 'DD/MM/YYYY HH24:MI') AS created_at,
                u.id AS uploadId,
                d.id AS id,
                COUNT(s.id) AS contSigners
            FROM 
                TABLE_NAME u
            JOIN 
                users us ON u.user_id = us.id
            LEFT JOIN 
                documents d ON d.upload_id = u.id AND d.deleted_at IS NULL  -- Adicionado filtro para garantir que o deleted_at seja NULL
            LEFT JOIN 
                signers s ON s.documents_id = d.id
            WHERE 
                d.deleted_at IS NULL  -- Garantir que apenas documentos não excluídos sejam selecionados
            GROUP BY 
                u.fileName, us.name, u.created_at, u.id, d.id
            ORDER BY 
                u.created_at DESC;
        ");
    }



    public function create($dados)
    {

        $uploadService = new UploadService();
        $signersService = new SignersService();

        $logFilePath = __DIR__ . '/log.txt';

        try {
            $users = json_decode($dados['users'], true); // Decodificando o JSON de usuários
            $signers = [];
            $electronicSigners = [];

            foreach ($users as $index => $user) {
                $signerData = [
                    "step" => $index + 1,
                    "title" => "Signer",
                    "name" => $user['name'],
                    "email" => $user['email'],
                ];

                if (isset($user['individualIdentificationCode']) && !empty($user['individualIdentificationCode'])) {
                    $signerData["individualIdentificationCode"] = $user['individualIdentificationCode'];
                }

                if ($user['electronicSigner']) {
                    $electronicSigners[] = $signerData;
                } else {
                    $signers[] = $signerData;
                }
            }

            $body = [
                "document" => [
                    "name" => $dados['fileName'],
                    "upload" => [
                        "id" => $dados["select-uploads"],
                        "name" => $dados["name_upload"]
                    ]
                ],
                "sender" => [
                    "name" => $_SESSION['user_name'],
                    "email" => $_SESSION['email'],
                    "individualIdentificationCode" => $_SESSION['cpf']
                ],
                "signers" => $signers,
                "electronicSigners" => $electronicSigners
            ];

            $response = $this->httpRequest(getenv('PORTAL_API_URL') . '/document/create', 'POST', $body, [
                "Token: " . getenv('PORTAL_API_TOKEN')
            ]);

            $response = json_decode($response, true);

            $upload = $uploadService->findOne(
                "SELECT id FROM uploads WHERE filename LIKE '{$dados['name_upload']}'"
            );
            $documento = $this->store([
                'id' => $response['id'],
                'key' => $response['chave'],
                'user_id' => $_SESSION['user_id'],
                'fileName' => $dados["fileName"],
                'upload_id' => $upload[0]->id
            ]);

            $signers = [];
            $urls = [];
            foreach ($response['attendees'] as $signer) {
                $urls[] = $signer['signUrl'];
            }

            foreach ($users as $index => $user) {
                $signerData = [
                    "user_id" => $user['id'],
                    "documents_id" =>  $documento->id,
                    "url" => $urls[$index]
                ];
                $signers[] = $signerData;
            }

            $signersService->create($signers);

            return json_encode(['success' => true, 'message' => 'Documento cadastrado com sucesso!']);
        } catch (\Exception $e) {
            return json_encode(['error' => true, 'message' => "Falha ao cadastrar Documento"]);
        }
    }

    public function findOne($sql)
    {
        return $this->search($sql);
    }

    public function getDocumentos($id)
    {
        try {
            $sql = "
            SELECT 
                us.name AS userName, 
                us.email AS userEmail,
                s.url AS signUrl
            FROM 
                TABLE_NAME s
            JOIN 
                users us ON s.user_id = us.id
            WHERE 
                s.documents_id = :documentId
            ";

            $params = ['documentId' => $id];

            $signers = $this->signersService->search($sql, $params);
            return json_encode(['sucess' => true, 'dados' => $signers]);
        } catch (\Exception $e) {
            return json_encode(['error' => true, 'dados' => ""]);
        }
    }

    public function verificarAssinatura($id)
    {
        $key = $this->search(
            "
            SELECT d.key
            FROM TABLE_NAME d
            WHERE d.id = :documentId
            ",
            ['documentId' => $id]
        );

        $url = getenv('PORTAL_API_URL') . '/document/ValidateSignatures?key=' . $key[0]->key;

        $response = $this->httpRequest($url, 'GET', [], [
            "accept: application/json",
            "Token: " . getenv('PORTAL_API_TOKEN')
        ]);

        return json_encode(['sucess' => true, 'dados' => $response,"url" => $key[0]->key]);
    }

    public function verificarStatus($id)
    {
        try {
            $url = getenv('PORTAL_API_URL') . '/document/details/' . $id;
            $response = $this->httpRequest($url, 'GET', [], [
                "accept: application/json",
                "Token: " . getenv('PORTAL_API_TOKEN')
            ]);

            return json_encode(['sucess' => true, 'dados' => $response]);
        } catch (\Exception $e) {
            return json_encode(['error' => true, 'dados' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $url = getenv('PORTAL_API_URL') . '/document/delete?id=' . $id;

            $headers = [
                "Token: " . getenv('PORTAL_API_TOKEN'),
            ];
    
            $response = $this->httpRequest($url, 'DELETE', [], $headers);

            $this->delete($id);

            return json_encode(['sucess' => true, 'mensagem' => "Deletado com Sucesso","dados" => $response]);
        } catch (\Exception $e) {
            return json_encode(['error' => true, 'mensagem' => "Erro ao Deletar"]);
        }
    }
}
