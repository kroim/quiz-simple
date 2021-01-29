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
        $this->route->get("/user-role", function () {
            $this->main->manageRole();
        });
        $this->route->post("/user-role", function () {
            $this->main->postManageRole($_REQUEST);
        });
        $this->route->get("/user-categories", function () {
            $this->main->manageCategories();
        });
        $this->route->post("/user-categories", function () {
            $this->main->postManageCategories($_REQUEST);
        });
        $this->route->get("/questions-all", function () {
            $this->main->manageQuestionsAll();
        });
        $this->route->post("/questions-all", function () {
            $this->main->postManageQuestionsAll($_REQUEST);
        });
        $this->route->get("/questions-own", function () {
            $this->main->manageQuestionsOwn();
        });
        $this->route->post("/questions-own", function () {
            $this->main->postManageQuestionsOwn($_REQUEST);
        });
        $this->route->get("/quizzes-all", function () {
            $this->main->manageQuizzesAll();
        });
        $this->route->post("/quizzes-all", function () {
            $this->main->postManageQuizzesAll($_REQUEST);
        });
        $this->route->get("/quizzes-own", function () {
            $this->main->manageQuizzesOwn();
        });
        $this->route->post("/quizzes-own", function () {
            $this->main->postManageQuizzesOwn($_REQUEST);
        });
        $this->route->get("/account", function () {
            $this->main->account();
        });
        $this->route->post("/account", function () {
            $this->main->postAccount($_REQUEST);
        });
        $this->route->get("/logout", function () {
            $this->main->logout();
        });
    }
}