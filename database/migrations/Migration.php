<?php

class Migration {
    protected $pdo;

    public function __construct() {
        $host = 'mini-erp-mysql';
        $db = 'mini_erp';
        $user = 'root';
        $pass = 'root';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $user, $pass);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    protected function query($sql) {
        return $this->pdo->exec($sql);
    }
}
