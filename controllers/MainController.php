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
        if (!isset($_SESSION['user_status']) || !$_SESSION['user_status']) {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                header("location: {$this->base_url}/login");
                die();
            } else {
                echo json_encode(['status'=>"error", "message"=>"You are not logged in"]);
                die();
            }
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
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "user_management";
        $sidebar->sub_menu = "user-role";
        $users = $this->mainModel->getUsers(1);
        require_once __DIR__ . "/../views/users/manage-role.php";
        die();
    }

    public function postManageRole($request)
    {
        $user_id = $request['user_id'];
        $user_role = $request['user_role'];
        $role_number = 3;
        if ($user_role == 'Teacher') $role_number = 2;
        $this->mainModel->updateUser($user_id, null, null, null, $role_number, null, null);
        echo json_encode(["status"=>"success", "message"=>"Updated user role"]);
        die();
    }

    public function manageCategories()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "user_management";
        $sidebar->sub_menu = "user-categories";
        $categories = $this->mainModel->getCategories();
        $sub_categories = $this->mainModel->getSubCategories();
        require_once __DIR__ . "/../views/users/manage-categories.php";
    }

    public function postManageCategories($request)
    {
        $action = $request["action"];
        switch ($action) {
            case "add_main_category":
                $name = $request["name"];
                $add_action = $this->mainModel->addMainCategory($name);
                if ($add_action) echo json_encode(["status"=>"success", "message"=>"Added a main category successfully"]);
                else echo json_encode(["status"=>"error", "message"=>"Failed a main category"]);
                break;
            case "edit_main_category":
                $id = $request['id'];
                $name = $request['name'];
                $edit_action = $this->mainModel->editMainCategory($id, $name);
                if ($edit_action) echo json_encode(["status"=>"success", "message"=>"Updated a main category successfully"]);
                else echo json_encode(["status"=>"error", "message"=>"Failed updating a main category"]);
                break;
            case "remove_main_category":
                $id = $request['id'];
                $remove_action = $this->mainModel->removeMainCategory($id);
                if ($remove_action) echo json_encode(["status"=>"success", "message"=>"Removed a main category successfully"]);
                else echo json_encode(["status"=>"error", "message"=>"Failed removing a main category"]);
                break;
            case "add_sub_category":
                $name = $request["name"];
                $category = $request["category"];
                $add_action = $this->mainModel->addSubCategory($name, $category);
                if ($add_action) echo json_encode(["status"=>"success", "message"=>"Added a sub category successfully"]);
                else echo json_encode(["status"=>"error", "message"=>"Failed a sub category"]);
                break;
            case "edit_sub_category":
                $id = $request['id'];
                $name = $request['name'];
                $parent = $request['parent'];
                $edit_action = $this->mainModel->editSubCategory($id, $name, $parent);
                if ($edit_action) echo json_encode(["status"=>"success", "message"=>"Updated a sub category successfully"]);
                else echo json_encode(["status"=>"error", "message"=>"Failed updating a sub category"]);
                break;
            case "remove_sub_category":
                $id = $request['id'];
                $remove_action = $this->mainModel->removeSubCategory($id);
                if ($remove_action) echo json_encode(["status"=>"success", "message"=>"Removed a sub category successfully"]);
                else echo json_encode(["status"=>"error", "message"=>"Failed removing a sub category"]);
                break;
            default:
                echo json_encode(["status"=>"error", "message"=>"Undefined method"]);
                break;
        }
        die();
    }

    public function manageQuestionsAll()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "questions";
        $sidebar->sub_menu = "questions-all";
        $categories = $this->mainModel->getCategories();
        $sub_categories = $this->mainModel->getSubCategories();
        $questions = $this->mainModel->getAllQuestions();
        require_once __DIR__ . "/../views/main/questions_all.php";
    }

    public function postManageQuestionsAll($request)
    {

    }

    public function manageQuestionsOwn()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "questions";
        $sidebar->sub_menu = "questions-own";
        $categories = $this->mainModel->getCategories();
        $sub_categories = $this->mainModel->getSubCategories();
        $questions = $this->mainModel->getQuestionsByUser($_SESSION['user_id']);
        require_once __DIR__ . "/../views/main/questions.php";
    }

    public function postManageQuestionsOwn($request)
    {
        $action = $request['action'];
        switch ($action) {
            case "add_question_own":
                $category = $request['category'];
                $sub_category = $request['sub_category'];
                $question = $request['question'];
                $answers = $request['answers'];
                $query_res = $this->mainModel->createQuestion($_SESSION['user_id'], $category, $sub_category, $question, $answers);
                if ($query_res) echo json_encode(["status"=>"success", "message"=>"Created a question successfully."]);
                else echo json_encode(["status"=>"error", "message"=>"Failed adding a question"]);
                break;
            case "edit_question_own":
                $question_id = $request['question_id'];
                $category = $request['category'];
                $sub_category = $request['sub_category'];
                $question = $request['question'];
                $answers = $request['answers'];
                $query_res = $this->mainModel->updateQuestion($question_id, $category, $sub_category, $question, $answers);
                if ($query_res) echo json_encode(["status"=>"success", "message"=>"Updated a question successfully."]);
                else echo json_encode(["status"=>"error", "message"=>"Failed updating a question"]);
                break;
            case "remove_question_own":
                $question_id = $request['question_id'];
                $query_res = $this->mainModel->removeQuestion($question_id);
                if ($query_res) echo json_encode(["status"=>"success", "message"=>"Removed a question successfully."]);
                else echo json_encode(["status"=>"error", "message"=>"Failed removing a question"]);
                break;
            default:
                echo json_encode(["status"=>"error", "message"=>"Undefined method"]);
                break;
        }
        die();
    }

    public function manageQuizzesAll()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "quizzes";
        $sidebar->sub_menu = "quizzes-all";
        require_once __DIR__ . "/../views/main/quizzes_all.php";
    }

    public function postManageQuizzesAll($request)
    {

    }

    public function manageQuizzesOwn()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "quizzes";
        $sidebar->sub_menu = "quizzes-own";
        require_once __DIR__ . "/../views/main/quizzes.php";
    }

    public function postManageQuizzesOwn($request)
    {

    }

    public function account()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "account";
        $sidebar->sub_menu = "";
        require_once __DIR__ . '/../views/users/account.php';
    }

    public function postAccount($request)
    {
        $action = $request['action'];
        if ($action == "change_profile") {
            $name = $request['name'];
            $email = $request['email'];
            $avatar = $request['avatar'];
            $description = $request['description'];
            $avatar_url = "";
            if (strlen($request['avatar']) > 200) {
                $avatar_path = "uploads/avatar/avatar_" . $_SESSION['user_id'] . ".png";
                $avatar_url = "/" . $avatar_path;
                $this->base64ToImage($avatar, $avatar_path);
            }
            $this->mainModel->updateUser($_SESSION['user_id'], $name, $email, null, null, $description, $avatar_url);
            $_SESSION["user_name"] = $name;
            $_SESSION["user_email"] = $email;
            $_SESSION["user_description"] = $description;
            $_SESSION["user_avatar"] = $avatar_url;
            echo json_encode(["status"=>"success", "message"=>"Update account information successfully"]);
            die();
        } else if ($action == "change_password") {
            $current_password = $request["current_password"];
            $new_password = $request["new_password"];
            $user = $this->mainModel->getUser($_SESSION['user_id']);
            if (!$user) {
                echo json_encode(["status"=>"error", "message"=>"User is not defined"]);
                die();
            }
            if (!password_verify($current_password, $user["password"])) {
                echo json_encode(["status"=>"error", "message"=>"Current password is wrong"]);
                die();
            }
            $this->mainModel->updateUser($_SESSION['user_id'], null, null, $new_password, null, null, null);
            echo json_encode(["status"=>"success", "message"=>"Password is changed successfully"]);
            die();
        } else {
            echo json_encode(["status"=>"error", "message"=>"Undefined method"]);
            die();
        }
    }

    public function logout()
    {
        try {
            $email = $_SESSION['user_email'];
            if ($email) $this->mainModel->logout($email);
        } catch (Exception $exception) {
        }
        session_destroy();
        header("location: " . $this->base_url);
    }

    public function base64ToImage($base64, $output)
    {
        $image_data = explode(";base64", $base64);
        $image_base64 = base64_decode($image_data[1]);
        file_put_contents($output, $image_base64);
    }
}
