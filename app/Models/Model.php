<?php

export('Models/User');
export('Models/Documento');
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
            type BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            update_at TIMESTAMP 
        );
        
      CREATE TABLE IF NOT EXISTS uploads (
            id SERIAL PRIMARY KEY, 
            user_id INT NOT NULL, 
            upload_id VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
        ";

        $pdo = self::getConnection();

        $pdo->exec($sql);
    }

    public function query($sql, $params = [])
    {
        $pdo = self::getConnection();

        // Dessa forma, não é necessário passar o nome da tabela, pois ele já está instanciado no model        
        $sql = str_replace('TABLE_NAME', $this->table, $sql);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function search($filters)
    {
        $pdo = self::getConnection();

        // Prepara a consulta com base nos critérios fornecidos
        $whereClause = '';
        $bindings = [];
        foreach ($filters as $column => $value) {
            $whereClause .= $column . " = :$column AND ";
            $bindings[$column] = $value;
        }

        // Remove o último "AND" extra da cláusula WHERE
        $whereClause = rtrim($whereClause, " AND ");

        $sql = "SELECT * FROM " . $this->table . " WHERE $whereClause";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindings);

        // Retorna os resultados
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

        $stmt = $pdo->prepare("INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    public function update($data, $id)
    {
        $pdo = self::getConnection();
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");

        $stmt = $pdo->prepare("UPDATE " . $this->table . " SET $setClause WHERE id = :id");
        $data['id'] = $id;

        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
