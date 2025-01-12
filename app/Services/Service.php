<?php

export('Services/UserService');
export('Services/DocumentoService');
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
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
        }
        if (strtoupper($method) === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_message = 'Erro cURL: ' . curl_error($ch);
            curl_close($ch);
            throw new Exception($error_message); 
        }

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_status >= 200 && $http_status < 300) {
            return $response;
        } else {
            throw new Exception("Erro na requisição: Status HTTP " . $http_status);
        }
    }
}
