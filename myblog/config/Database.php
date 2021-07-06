<?php

class Database
{
    // DB Params
    private $host = 'localhost:3308';
    private $db_name = 'myblog';
    private $username = 'root';
    private $password = 'root';
    private $conn;

    // DB Connect
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connectin Erro: ' . $e->getMessage();
        }

        return $this->conn;
    }
}