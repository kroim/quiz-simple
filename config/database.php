<?php

class Database {
    private $_db_server;
    private $_db_user;
    private $_db_password;
    private $_db_name;
    private $conn;

    public function __construct()
    {
        $parsed = parse_ini_file('.env', true);
        $this->_db_server = $parsed["db_server"];
        $this->_db_user = $parsed["db_user"];
        $this->_db_password = $parsed["db_password"];
        $this->_db_name = $parsed["db_name"];
    }

    public function _init()
    {
        // check connection
        $this->conn = new mysqli($this->_db_server, $this->_db_user, $this->_db_password, $this->_db_name);
        if ($this->conn->connect_error) return false;
        // user table
        $query = "SELECT id FROM users";
        $result = mysqli_query($this->conn, $query);
        if(empty($result)) {
            $query = "CREATE TABLE users (
                          id int(11) auto_increment,
                          name varchar(255) not null, 
                          email varchar(255) not null,
                          password varchar(255) not null,
                          role int not null,
                          login_status int,
                          email_verified_at datetime,
                          avatar varchar(255),
                          description text,
                          remember_token varchar(255),
                          created_at datetime,
                          updated_at datetime,
                          PRIMARY KEY  (id)
                          )";
            mysqli_query($this->conn, $query);
        }
        return true;
    }
}