<?php
include "config/db.php";
if (isset($_SESSION['user']) && $_SESSION['user']['login'] == 1) {
    var_dump("Home routes");
    include_once "routes/home_routes.php";
} else {
    var_dump("Auth routes");
    include_once "routes/auth_routes.php";
}