<?php
session_start();
include "routes/routes.php";
include "config/database.php";

$routes = new Routes();
$database = new Database();


