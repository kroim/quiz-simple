<?php
include_once 'classes/Request.php';
include_once 'classes/Router.php';
$router = new Router(new Request);

$router->get('/profile', function($request) {
    return <<<HTML
  <h1>Profile</h1>
HTML;
});

$router->post('/data', function($request) {

    return json_encode($request->getBody());
});