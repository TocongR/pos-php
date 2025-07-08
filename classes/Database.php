<?php
namespace Classes;

use PDO;

class Database {
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite:' . DB_PATH);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("PRAGMA foreign_keys = ON");
    }

    public function query(string $sql, array $params = []): \PDOStatement 
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}