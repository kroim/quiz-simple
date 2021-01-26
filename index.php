<?php
//error_reporting(0);
session_start();
include "routes/routes.php";
include "config/database.php";

$database = new Database();

if (!$database->_init()) {
    echo "Database connection error";
    die();
}

$routes = new Routes();