<?php

//Criação da Casse responsável pela instancia do banco no padrão singleton
class Database {
    private static $instance;
    private $pdo;

    private function __construct($dsn, $username, $password, $options) {
        $this->pdo = new PDO($dsn, $username, $password, $options);
    }

    public static function getInstance($dsn, $username, $password, $options) {
        if (!self::$instance) {
            self::$instance = new self($dsn, $username, $password, $options);
        }

        return self::$instance;
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    public function getConnection() {
        return $this->pdo;
    }
}
