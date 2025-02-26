<?php

class Connection {

    private $host = "localhost";
    private $dbname = "crud_db";
    private $username = "root";
    private $password = "";

    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname , $this->username , $this->password); 
        } catch (PDOException $e) {
           echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>