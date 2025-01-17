<?php

export('Models/User');
export('Models/Documento');
export('Models/Upload');
export('Models/Signers');
loadEnv();

class Model
{
    protected static $pdo;
    protected $table;  // Aqui armazenamos o nome da tabela, que será definida nas classes filhas.

    public function __construct($table = null)
    {
        $this->table = $table;
    }

    // Estabelecendo a conexão com o banco de dados PostgreSQL
    public static function getConnection()
    {
        if (!self::$pdo) {
            try {
                $host = getenv('DB_HOST');
                $dbname = getenv('DB_NAME');
                $user = getenv('DB_USER');
                $password = getenv('DB_PASSWORD');
                $port = getenv('DB_PORT');
                $connection = getenv('DB_CONNECTION');
                self::$pdo = new PDO("$connection:host=$host;port=$port;dbname=$dbname", $user, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        return self::$pdo;
    }

    public static function createTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            cpf VARCHAR(11) UNIQUE NOT NULL,
            type BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            update_at TIMESTAMP ,
            deleted_at TIMESTAMP,
            electronicSigner BOOLEAN
        );
        
        CREATE TABLE IF NOT EXISTS uploads (
            id SERIAL PRIMARY KEY, 
            user_id INT NOT NULL, 
            fileName VARCHAR(255) UNIQUE NOT NULL,
            upload_id VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
    
        CREATE TABLE IF NOT EXISTS documents (
            id SERIAL PRIMARY KEY, 
            user_id INT NOT NULL, 
            fileName VARCHAR(255) NOT NULL,
            key VARCHAR(255) NOT NULL,
            upload_id INT NOT NULL, 
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            deleted_at TIMESTAMP ,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (upload_id) REFERENCES uploads(id) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS signers (
            id SERIAL PRIMARY KEY, 
            user_id INT NOT NULL, 
            url VARCHAR(255) NOT NULL,
            documents_id INT NOT NULL,  
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (documents_id) REFERENCES documents(id) ON DELETE CASCADE
        );

        
        INSERT INTO users (name, email, password, cpf, type, electronicSigner)
        VALUES ('admin', 'admin@admin.com', '\$2y\$10\$NrsDbX2XOnOsIHZSkMCGdO6k7s52mJCatYy816oo1eyNi1K7/ukU.', '12345678901', TRUE, TRUE);        ";

        $pdo = self::getConnection();

        $pdo->exec($sql);
    }


    public function query($sql, $params = [])
    {
        $pdo = self::getConnection();

        $sql = str_replace('TABLE_NAME', $this->table, $sql);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function search($filters)
    {
        $pdo = self::getConnection();

        $whereClause = '';
        $bindings = [];
        foreach ($filters as $column => $value) {
            $whereClause .= $column . " = :$column AND ";
            $bindings[$column] = $value;
        }

        $whereClause = rtrim($whereClause, " AND ");

        $sql = "SELECT * FROM " . $this->table . " WHERE $whereClause";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindings);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function all()
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM " . $this->table . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $pdo = self::getConnection();
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $stmt = $pdo->prepare("INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders) RETURNING *");
        $stmt->execute($data);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function update($data, $id)
    {
        $pdo = self::getConnection();
        $setClause = "";
    
        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                $setClause .= "$key = :$key, ";
            }
        }
    
        $setClause = rtrim($setClause, ", ");
    
        if (empty($setClause)) {
            return false;
        }
    
        $stmt = $pdo->prepare("UPDATE " . $this->table . " SET $setClause WHERE id = :id");
        $data['id'] = $id;
    
        return $stmt->execute($data);
    }
    

    public function delete($id)
    {
        $pdo = self::getConnection();

        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE " . $this->table . " SET deleted_at = NOW() WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
        
    }    
}
