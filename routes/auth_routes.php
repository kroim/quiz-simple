<?php
include_once 'classes/Request.php';
include_once 'classes/Router.php';
$router = new Router(new Request);
$router->get('/', function() {
    return "Hello World";
});