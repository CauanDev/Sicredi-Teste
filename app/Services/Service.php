<?php

export('Services/UserService');

class Service
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model; // Defina o modelo que o service irá usar
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }
}
