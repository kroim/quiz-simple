<?php

// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");
// load the registration class
require_once("classes/Registration.php");
$login = new Login();

$currDir = dirname(__FILE__);
include("$currDir/views/partials/head.php");
// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    include("views/logged_in.php");
} else {
    include("views/not_logged_in.php");
}