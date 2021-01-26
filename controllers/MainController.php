<?php
include "./views/main/home.php";
include "./views/main/about.php";
include "./views/main/contact.php";

class MainController
{
    private $base_url;
    public function __construct()
    {
        $parsed = parse_ini_file('.env', true);
        $this->base_url = $parsed["base_url"];
    }

    public function check_session()
    {
        if (isset($_SESSION['user'])) {
            print_r($_SESSION['user']);
            print_r($_SESSION['login']);
            print_r("Home routes");
        } else {
            print_r("Auth routes");
            header("location: {$this->base_url}/login");
        }
    }

    public function home()
    {
        $this->check_session();
        echo "Home Page";
    }
    public function about()
    {
        echo "About Page";
    }
    public function contact()
    {
        echo "Contact Page";
    }
}
