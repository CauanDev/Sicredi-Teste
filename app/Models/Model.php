<?php

export('Models/User');
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
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );";

        $pdo = self::getConnection();

        $pdo->exec($sql);
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
