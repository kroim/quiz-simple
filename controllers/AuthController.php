<?php
include "models/AuthModel.php";

class AuthController
{
    private $base_url;
    private $authModel;
    public function __construct()
    {
        $parsed = parse_ini_file('.env', true);
        $this->base_url = $parsed["base_url"];
        $this->authModel = new AuthModel();
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
        $name = $request['name'];
        if (!$name) {
            echo json_encode(['status'=>'error', 'message'=>'Name is required']);
            die();
        }
        $email = $request['email'];
        if (!$email) {
            echo json_encode(['status'=>'error', 'message'=>'Email is required']);
            die();
        }
        $password = $request['password'];
        if (!$password) {
            echo json_encode(['status'=>'error', 'message'=>'Password is required']);
            die();
        }
        $role = $request['role'];
        $role_number = 3;
        if ($role == "Teacher") $role_number = 2;
        $checkUser = $this->authModel->checkUser($email);
        if ($checkUser) {
            echo json_encode(['status'=>'error', 'message'=>'The email is registered already']);
            die();
        }
        $registerRes = $this->authModel->createUser($name, $email, $password, $role_number);
        if ($registerRes) {
            echo json_encode(['status'=>'success', 'message'=>'Register is success']);
            die();
        } else {
            echo json_encode(['status'=>'error', 'message'=>'Register is failed']);
            die();
        }
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
