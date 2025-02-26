<?php

class Users {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function save_users() {
        $sql = "INSERT INTO users SET firstname = ?, lastname = ?";
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $save_user = $this->conn->prepare($sql);

        $save_user->bindParam(1, $this->firstname);
        $save_user->bindParam(2, $this->lastname);

        if ($save_user->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function display_users() {

        $sql = "SELECT * FROM users";
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $display_user = $this->conn->prepare($sql);

        $display_user->execute();
        return $display_user;
    }

    public function update_users() {

        $sql = "UPDATE users SET firstname = ?, lastname = ? WHERE id = ?";
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $update_user = $this->conn->prepare($sql);

        $update_user->bindParam(1, $this->firstname);
        $update_user->bindParam(2, $this->lastname);
        $update_user->bindParam(3, $this->id);

        if ($update_user->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function delete_users() {

        $sql = "DELETE FROM users WHERE id = ?";
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $delete_user = $this->conn->prepare($sql);

        $delete_user->bindParam(1, $this->id);

        if ($delete_user->execute()) {
            return true;
        } else {
            return false;
        }
        
    }
}
?>