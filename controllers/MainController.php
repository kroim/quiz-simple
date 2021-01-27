<?php
include "models/MainModel.php";

class MainController
{
    private $base_url;
    private $mainModel;
    public function __construct()
    {
        $parsed = parse_ini_file('.env', true);
        $this->base_url = $parsed["base_url"];
        $this->mainModel = new MainModel();
    }

    public function check_session()
    {
        if (isset($_SESSION['user_status']) && $_SESSION['user_status']) {
//            print_r($_SESSION['user']);
//            print_r($_SESSION['login']);
//            print_r("Home routes");
        } else {
//            print_r("Auth routes");
            header("location: {$this->base_url}/login");
        }
    }

    public function home()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "dashboard";
        $sidebar->sub_menu = "";
        require_once __DIR__ . '/../views/main/home.php';
    }
    public function manageRole()
    {
        $this->check_session();
        echo "About Page";
    }
    public function manageTeachers()
    {
        $this->check_session();
        echo "About Page";
    }
    public function manageStudents()
    {
        $this->check_session();
        echo "About Page";
    }
    public function account()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "account";
        $sidebar->sub_menu = "";
        require_once __DIR__ . '/../views/main/account.php';
    }
    public function logout()
    {
        try {
            $email = $_SESSION['user_email'];
            if ($email) $this->mainModel->logout($email);
        } catch (Exception $exception) {}
        session_destroy();
        header("location: " . $this->base_url);
    }
}
