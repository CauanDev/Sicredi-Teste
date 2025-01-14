<?php

class DocumentoService extends Service
{
    public function __construct()
    {
        parent::__construct(new Documento());
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
                'user_id' => $_SESSION['user_id'],
                'fileName' => $dados["fileName"],
                'upload_id' => $upload[0]->id
            ]);

            $signers = [];

            foreach ($users as $user) {
                $signerData = [
                    "user_id" => $user['id'],
                    "documents_id" =>  $documento->id,
                ];
                $signers[] = $signerData;
            }

            $signersService->create($signers);

            $logContent = json_encode($signers, JSON_PRETTY_PRINT);
            file_put_contents($logFilePath, $logContent . PHP_EOL, FILE_APPEND);
            return json_encode(['success' => true, 'message' => 'Documento cadastrado com sucesso!']);
        } catch (\Exception $e) {
            $logContent = json_encode($e->getMessage(), JSON_PRETTY_PRINT);
            file_put_contents($logFilePath, $logContent . PHP_EOL, FILE_APPEND);
            return json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function findOne($sql)
    {
        return $this->search($sql);
    }
}
