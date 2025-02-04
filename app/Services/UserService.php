<?php

class UserService extends Service
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function getUser($id)
    {
        $user = $this->findOne(['id' => $id]);
        return json_encode(['success' => true, 'dados' => $user]);
    }

    public function atualizarUsuario($dados)
    {
        try {
            if (isset($dados['password'])) {
                $dados['password'] = password_hash($dados['password'], PASSWORD_BCRYPT);
            }
            $this->update($dados, $dados['id']);

            return json_encode(['success' => true, 'mensagem' => "Atualizado com Sucesso"]);
        } catch (\Exception $e) {
            throw $e;
            return json_encode(['error' => true, 'mensagem' => "Erro ao Atualizar"]);
        }
    }

    public function login($dados)
    {
        try {
            $users =  $this->findOne(['email' => $dados['email']]);

            if (!empty($users)) {
                $user = $users[0];

                if (password_verify($dados['password'], $user->password)) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_name'] = $user->name;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['cpf'] = $user->cpf;
                    $_SESSION['admin'] = ($user->type === true);
                    return json_encode(['success' => true, 'message' => 'Usuário logado com sucesso']);
                } else {
                    return json_encode([
                        'success' => false,
                        'dados_invalidos' => [
                            'email' => 'E-mail ou usuário não encontrado.',
                            'password' => 'Senha incorreta.'
                        ]
                    ]);
                }
            } else {
                return json_encode([
                    'success' => false,
                    'dados_invalidos' => [
                        'email' => 'E-mail ou usuário não encontrado.'
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return json_encode(['error' => true, 'error' => $e->getMessage()]);
        }
    }

    public function create($dados)
    {
        try {
            $emailVerificado = $this->verificarEmail($dados['email']);
            $emailVerificado = json_decode($emailVerificado, true);

            if (!$emailVerificado['success'] || !$emailVerificado['resultado']) {
                return json_encode(['error' => true, 'dados_invalidos' => ['email' => 'E-mail inválido ou não encontrado.']]);
            }


            $hashPassword = password_hash($dados['password'], PASSWORD_BCRYPT);

            $this->store([
                'email' => $dados['email'],
                'password' => $hashPassword,
                'name' => $dados['name'],
                'cpf' => $dados['cpf'],
                "electronicSigner" => true
            ]);

            return json_encode(['success' => true, 'message' => 'Usuário cadastrado com sucesso!']);
        } catch (\Exception $e) {
            return json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function getPessoas()
    {
        return $this->search("
            SELECT 
                name AS label,
                email AS value,
                cpf AS target,
                id as ID,
                TO_CHAR(created_at, 'DD/MM/YYYY HH24:MI') AS criado_em,
                electronicSigner as status
            FROM TABLE_NAME
            WHERE deleted_at IS NULL;
        ");
    }

    public function dataTable()
    {
        $signerService = new SignersService();
        $sql = "
        SELECT
        *,
        TO_CHAR(created_at, 'DD/MM/YYYY HH24:MI') AS criado_em   
        FROM 
                TABLE_NAME 
            WHERE 
                user_id = :userID
            ";

        $params = ['userID' => $_SESSION['user_id']];

        return $signerService->search($sql, $params);
    }

    private function verificarEmail($email)
    {
        $apiUrl = getenv('EMAILABLE_API_URL');
        $apiToken = getenv('EMAILABLE_API_TOKEN');

        if (empty($apiUrl) || empty($apiToken)) {
            return json_encode(['error' => true, 'message' => 'Configurações da API não encontradas.']);
        }

        $queryParams = http_build_query([
            'email' => $email,
            'api_key' => $apiToken
        ]);

        $url = "{$apiUrl}/verify?" . $queryParams;

        try {
            $response = $this->httpRequest($url);

            if ($response) {
                $dados = json_decode($response, true);

                if (isset($dados['state']) && $dados['state'] === 'deliverable') {
                    return json_encode(['success' => true, 'resultado' => true]);
                } else {
                    return json_encode(['success' => true, 'resultado' => false]);
                }
            } else {
                throw new Exception("Erro ao verificar o e-mail. Resposta inválida.");
            }
        } catch (Exception $e) {
            return json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
