<?php

export('Services/UserService');
loadEnv();

class Service
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model; // Defina o modelo que o service irá usar
    }

    protected function store($dados)
    {
        return $this->model->create($dados);
    }

    protected function update($dados, $id)
    {
        return $this->model->update($dados, $id);
    }

    protected function delete($id)
    {
        return $this->model->delete($id);
    }

    protected function findOne($dados)
    {
        return $this->model->search($dados);
    }

    protected function httpRequest($url, $method = 'GET', $data = [], $headers = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Configura o método HTTP (Put ou POST)
        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Envia os dados no corpo da requisição
        }
        if (strtoupper($method) === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $response = curl_exec($ch);

        // Verifica se houve algum erro na requisição
        if (curl_errno($ch)) {
            $error_message = 'Erro cURL: ' . curl_error($ch);
            curl_close($ch);
            throw new Exception($error_message);  // Lança uma exceção caso ocorra um erro
        }

        curl_close($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        // Verifica se a requisição foi bem-sucedida
        if ($http_status >= 200 && $http_status < 300) {
            return $response;
        } else {
            throw new Exception("Erro na requisição: Status HTTP " . $http_status);
        }
    }
}
