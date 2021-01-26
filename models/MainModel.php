<?php

class MainModel
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

    public function logout($email) {
        $sql = "update users set login_status = 0 where email='". $email ."'";
        mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
    }
}