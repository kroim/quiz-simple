<?php

include "route.php";
include "controllers/AuthController.php";
include "controllers/MainController.php";
class Routes
{
    private $base_url;
    private $route;
    private $auth;
    private $main;
    public function __construct()
    {
        $parsed = parse_ini_file('.env', true);
        $this->base_url = $parsed["base_url"];
        $this->auth = new AuthController();
        $this->main = new MainController();
        $this->route = new Route();
        $this->authRoutes();
        $this->mainRoutes();
        $this->route->submit();
    }

    public function authRoutes()
    {

        $this->route->get("/login", function () {
            $this->auth->getLogin();
        });
        $this->route->post("/login", function () {
            $this->auth->postLogin($_REQUEST);
        });
        $this->route->get("/register", function () {
            $this->auth->getRegister();
        });
        $this->route->post("/register", function () {
            $this->auth->postRegister($_REQUEST);
        });
        $this->route->get("/forgot-password", function () {
            $this->auth->getForgotPassword();
        });
        $this->route->post("/forgot-password", function () {
            $this->auth->postForgotPassword($_REQUEST);
        });
        $this->route->get("/reset-password", function () {
            $this->auth->getResetPassword();
        });
        $this->route->post("/reset-password", function () {
            $this->auth->postResetPassword($_REQUEST);
        });
    }

    public function mainRoutes()
    {
        $this->route->get("/", function () {
            $this->main->home();
        });
        $this->route->get("/about", function () {
            $this->main->about();
        });
        $this->route->get("/contact", function () {
            $this->main->contact();
        });
        $this->route->get("/logout", function () {
            $this->main->logout();
        });
    }
}