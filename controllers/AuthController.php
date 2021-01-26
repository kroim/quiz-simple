<?php
//session_start();
include "./views/auth/login.php";

class AuthController
{
    public function __construct()
    {
    }

    public function getLogin()
    {
        echo "Login Page";
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
        echo "Register page";
    }

    public function postRegister($request)
    {
        echo "Register post";
    }

    public function getForgotPassword()
    {
        echo "Forgot password page";
    }

    public function postForgotPassword($request)
    {
        echo "Forgot password post";
    }

    public function getResetPassword()
    {
        echo "Reset password page";
    }

    public function postResetPassword($request)
    {
        echo "Reset password post";
    }
}
