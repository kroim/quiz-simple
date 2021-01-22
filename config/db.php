<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "quiz-simple";

define("DB_HOST", $servername);
define("DB_USER", $username);
define("DB_PASS", $password);
define("DB_NAME", $database);

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT id FROM users";
$result = mysqli_query($conn, $query);

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
    $result = mysqli_query($conn, $query);
}