<?php

// include the configs / constants for the database connection
require_once("config/db.php");

// load the registration class
require_once("classes/Registration.php");

// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$registration = new Registration();
$currDir = dirname(__FILE__);
include("$currDir/views/partials/head.php");
// show the register view (with the registration form, and messages/errors)
include("views/register.php");
