<?php

class SignersService extends Service
{
    public function __construct()
    {
        parent::__construct(new Signers());
    }

    public function create($signers)
    {
        try {
            foreach($signers as $signer){
                $this->store($signer);
            }
            return ["sucess"=>true];
        } catch (\Exception $e) {
            return ["error"=>true, "message"=>$e->getMessage()];
        }
    }

    // public function dataTable()
    // {
    //     return $this->search("
    //         SELECT uploads.id, uploads.fileName, users.name AS user_name, 
    //             TO_CHAR(uploads.created_at, 'DD/MM/YYYY HH24:MI') AS formatted_created_at
    //         FROM {$this->model->getTable()}
    //         JOIN users ON uploads.user_id = users.id
    //     ");
    // }


    public function findOne($sql)
    {
        return $this->search($sql);
    }
}
