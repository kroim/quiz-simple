<?php

class AuthModel
{
    private $conn = null;
    public function __construct()
    {
        $db = new Database();
        if (!$db->_init()) {
            die("DB Connection failed");
        }
        $this->conn = $db->connection();
    }

    public function createUser($name, $email, $password, $role)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $sql = "insert into users (name, email, password, role, created_at, updated_at) values ('"
            . $name ."', '" . $email . "', '" . $password_hash . "', '" . $role . "', '" . $created_at . "', '" . $updated_at . "')";
        return mysqli_query($this->conn, $sql);
    }

    public function checkUser($email) {
        $sql = "select * from users where email='" . $email . "'";
        $select = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($select)) return true;  // exist email already
        return false;  // don't exist email
    }
}