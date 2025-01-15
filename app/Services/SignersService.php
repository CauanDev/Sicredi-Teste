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
            foreach ($signers as $signer) {
                $this->store($signer);
            }
        } catch (\Exception $e) {
            return "";
        }
    }

    public function dataTable()
    {
        return $this->search("
            SELECT 
                s.id AS signer_id,
                s.url AS signing_url,
                d.id AS document_id,
                d.fileName AS document_name,
                TO_CHAR(d.created_at, 'DD/MM/YYYY HH24:MI') AS document_created_at
            FROM 
                TABLE_NAME s
            JOIN 
                documents d ON s.documents_id = d.id
            WHERE 
                s.user_id = :user_id
            ORDER BY 
                d.created_at DESC;
        ", ['user_id' => $_SESSION['user_id']]);
    }

    public function findOne($sql)
    {
        return $this->search($sql);
    }
}
