<?php

class AuthController
{
    private $base_url;
    public function __construct()
    {
        $parsed = parse_ini_file('.env', true);
        $this->base_url = $parsed["base_url"];
    }

    public function getLogin()
    {
        $base_url = $this->base_url;
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function postLogin($request)
    {
        $user = (object) array(
            "name"=>"Wonder",
            "email"=>"wonder@test.com",
            "role"=>2,
            "login_status"=>1
        );
        $_SESSION['user'] = serialize($user);
        $_SESSION['login'] = 1;
        echo "Login post".$_SESSION['user'];
    }

    public function getRegister()
    {
        $base_url = $this->base_url;
        require_once __DIR__ . "/../views/auth/register.php";
    }

    public function postRegister($request)
    {
        echo "Register post";
    }

    public function getForgotPassword()
    {
        $base_url = $this->base_url;
        require_once __DIR__ . "/../views/auth/forgot-password.php";
    }

    public function postForgotPassword($request)
    {
        echo "Forgot password post";
    }

    public function getResetPassword()
    {
        $base_url = $this->base_url;
        require_once __DIR__ . "/../views/auth/reset-password.php";
    }

    public function postResetPassword($request)
    {
        echo "Reset password post";
    }
}
