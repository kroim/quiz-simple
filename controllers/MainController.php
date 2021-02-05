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
                echo json_encode(['status' => "error", "message" => "You are not logged in"]);
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
        $tests = array();
        if ($_SESSION['user_role'] == 1) {
            $query_res = $this->mainModel->getAllTests();
            $ids = array();
            for ($j = 0; $j < count($query_res); $j++) {
                $item = new stdClass();
                $id = $query_res[$j]['id'];
                if (in_array($id, $ids)) {
                    $index = array_search($id, $ids);
                    array_push($tests[$index]->questions, $query_res[$j]['question']);
                    array_push($tests[$index]->answers, $query_res[$j]['answers']);
                } else {
                    array_push($ids, $id);
                    $item->id = $query_res[$j]['id'];
                    $item->name = $query_res[$j]['name'];
                    $item->email = $query_res[$j]['email'];
                    $item->questions = array($query_res[$j]['question']);
                    $item->answers = array($query_res[$j]['answers']);
                    $tests[] = $item;
                }
            }
        }
        else if ($_SESSION['user_role'] == 2) {
            $query_res = $this->mainModel->getTestsByTeacher($_SESSION['user_id']);
            $ids = array();
            for ($j = 0; $j < count($query_res); $j++) {
                $item = new stdClass();
                $id = $query_res[$j]['id'];
                if (in_array($id, $ids)) {
                    $index = array_search($id, $ids);
                    array_push($tests[$index]->questions, $query_res[$j]['question']);
                    array_push($tests[$index]->answers, $query_res[$j]['answers']);
                } else {
                    array_push($ids, $id);
                    $item->id = $query_res[$j]['id'];
                    $item->name = $query_res[$j]['name'];
                    $item->email = $query_res[$j]['email'];
                    $item->questions = array($query_res[$j]['question']);
                    $item->answers = array($query_res[$j]['answers']);
                    $tests[] = $item;
                }
            }
        } else {
            $query_res = $this->mainModel->getTestsByStudent($_SESSION['user_id']);
            $ids = array();
            for ($j = 0; $j < count($query_res); $j++) {
                $item = new stdClass();
                $id = $query_res[$j]['id'];
                if (in_array($id, $ids)) {
                    $index = array_search($id, $ids);
                    array_push($tests[$index]->questions, $query_res[$j]['question']);
                    array_push($tests[$index]->answers, $query_res[$j]['answers']);
                } else {
                    array_push($ids, $id);
                    $item->id = $query_res[$j]['id'];
                    $item->questions = array($query_res[$j]['question']);
                    $item->answers = array($query_res[$j]['answers']);
                    $tests[] = $item;
                }
            }
        }
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
        echo json_encode(["status" => "success", "message" => "Updated user role"]);
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
                if ($add_action) echo json_encode(["status" => "success", "message" => "Added a main category successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed a main category"]);
                break;
            case "edit_main_category":
                $id = $request['id'];
                $name = $request['name'];
                $edit_action = $this->mainModel->editMainCategory($id, $name);
                if ($edit_action) echo json_encode(["status" => "success", "message" => "Updated a main category successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed updating a main category"]);
                break;
            case "remove_main_category":
                $id = $request['id'];
                $remove_action = $this->mainModel->removeMainCategory($id);
                if ($remove_action) echo json_encode(["status" => "success", "message" => "Removed a main category successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed removing a main category"]);
                break;
            case "add_sub_category":
                $name = $request["name"];
                $category = $request["category"];
                $add_action = $this->mainModel->addSubCategory($name, $category);
                if ($add_action) echo json_encode(["status" => "success", "message" => "Added a sub category successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed a sub category"]);
                break;
            case "edit_sub_category":
                $id = $request['id'];
                $name = $request['name'];
                $parent = $request['parent'];
                $edit_action = $this->mainModel->editSubCategory($id, $name, $parent);
                if ($edit_action) echo json_encode(["status" => "success", "message" => "Updated a sub category successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed updating a sub category"]);
                break;
            case "remove_sub_category":
                $id = $request['id'];
                $remove_action = $this->mainModel->removeSubCategory($id);
                if ($remove_action) echo json_encode(["status" => "success", "message" => "Removed a sub category successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed removing a sub category"]);
                break;
            default:
                echo json_encode(["status" => "error", "message" => "Undefined method"]);
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
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            echo json_encode(["status" => "error", "message" => "Permission is not defined"]);
            die();
        }
        $action = $request['action'];
        switch ($action) {
            case "add_question_all":
                $category = $request['category'];
                $sub_category = $request['sub_category'];
                $question = $request['question'];
                $answers = $request['answers'];
                $query_res = $this->mainModel->createQuestion($_SESSION['user_id'], $category, $sub_category, $question, $answers);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Created a question successfully."]);
                else echo json_encode(["status" => "error", "message" => "Failed adding a question"]);
                break;
            case "edit_question_all":
                $question_id = $request['question_id'];
                $category = $request['category'];
                $sub_category = $request['sub_category'];
                $question = $request['question'];
                $answers = $request['answers'];
                $query_res = $this->mainModel->updateQuestion($question_id, $category, $sub_category, $question, $answers);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Updated a question successfully."]);
                else echo json_encode(["status" => "error", "message" => "Failed updating a question"]);
                break;
            case "remove_question_all":
                $question_id = $request['question_id'];
                $query_res = $this->mainModel->removeQuestion($question_id);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Removed a question successfully."]);
                else echo json_encode(["status" => "error", "message" => "Failed removing a question"]);
                break;
            default:
                echo json_encode(["status" => "error", "message" => "Undefined method"]);
                break;
        }
        die();
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
                if ($query_res) echo json_encode(["status" => "success", "message" => "Created a question successfully."]);
                else echo json_encode(["status" => "error", "message" => "Failed adding a question"]);
                break;
            case "edit_question_own":
                $question_id = $request['question_id'];
                $category = $request['category'];
                $sub_category = $request['sub_category'];
                $question = $request['question'];
                $answers = $request['answers'];
                $query_res = $this->mainModel->updateQuestion($question_id, $category, $sub_category, $question, $answers);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Updated a question successfully."]);
                else echo json_encode(["status" => "error", "message" => "Failed updating a question"]);
                break;
            case "remove_question_own":
                $question_id = $request['question_id'];
                $query_res = $this->mainModel->removeQuestion($question_id);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Removed a question successfully."]);
                else echo json_encode(["status" => "error", "message" => "Failed removing a question"]);
                break;
            default:
                echo json_encode(["status" => "error", "message" => "Undefined method"]);
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
        $questions = $this->mainModel->getAllQuestions();
        $quizzes = $this->mainModel->getAllQuizzes();
        $quiz_ids = array();
        $new_quizzes = array();
        for ($i = 0; $i < count($quizzes); $i++) {
            $id = $quizzes[$i]['id'];
            if (in_array($id, $quiz_ids)) {
                $index = array_search($id, $quiz_ids);
                array_push($new_quizzes[$index]->question_ids, $quizzes[$i]['question_id']);
                array_push($new_quizzes[$index]->questions, $quizzes[$i]['question']);
                array_push($new_quizzes[$index]->durations, $quizzes[$i]['duration']);
            } else {
                array_push($quiz_ids, $id);
                $item = new stdClass();
                $item->id = $id;
                $item->code = $quizzes[$i]['code'];
                $item->question_ids = array($quizzes[$i]['question_id']);
                $item->questions = array($quizzes[$i]['question']);
                $item->durations = array($quizzes[$i]['duration']);
                $item->total_duration = $quizzes[$i]['total_duration'];
                $item->total_duration_flag = $quizzes[$i]['total_duration_flag'];
                $new_quizzes[] = $item;
            }
        }
        require_once __DIR__ . "/../views/main/quizzes_all.php";
    }

    public function postManageQuizzesAll($request)
    {
        $action = $request['action'];
        switch ($action) {
            case "add_quiz_all":
                $questions_string = $request['questions'];
                $questions = json_decode($questions_string);
                $total_duration_flag_string = $request['total_duration_flag'];
                $total_duration_flag = 0;
                $total_duration = 0;
                $durations = array();
                if ($total_duration_flag_string == "true") {
                    $total_duration_flag = 1;
                    $total_duration = $request['total_duration'];
                } else {
                    $durations_string = $request['durations'];
                    $durations = json_decode($durations_string);
                    if (count($questions) != count($durations)) {
                        echo json_encode(["status" => "error", "message" => "Failed creating a quiz from durations"]);
                        die();
                    }
                }
                $code = $this->getNewCode();
                $query_res = $this->mainModel->addQuiz($_SESSION['user_id'], $code, $questions, $durations, $total_duration, $total_duration_flag);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Created a quiz successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed creating a quiz"]);
                break;
            case "edit_quiz_all":
                $quiz_id = $request['quiz_id'];
                $questions_string = $request['questions'];
                $questions = json_decode($questions_string);
                $total_duration_flag = 0;
                $total_duration = 0;
                $durations = array();
                if ($request['total_duration_flag'] == "true") {
                    $total_duration_flag = 1;
                    $total_duration = $request['total_duration'];
                } else {
                    $durations_string = $request['durations'];
                    $durations = json_decode($durations_string);
                    if (count($questions) != count($durations)) {
                        echo json_encode(["status" => "error", "message" => "Failed creating a quiz from durations"]);
                        die();
                    }
                }
                $query_res = $this->mainModel->editQuiz($quiz_id, $questions, $durations, $total_duration, $total_duration_flag);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Updated a quiz successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed updating a quiz"]);
                break;
            case "remove_quiz_all":
                $quiz_id = $request['quiz_id'];
                $query_res = $this->mainModel->removeQuiz($quiz_id);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Removed a quiz successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed removing a quiz"]);
                break;
            default:
                echo json_encode(["status" => "error", "message" => "Undefined method"]);
                break;
        }
        die();
    }

    public function manageQuizzesOwn()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "quizzes";
        $sidebar->sub_menu = "quizzes-own";
        $questions = $this->mainModel->getAllQuestions();
        $quizzes = $this->mainModel->getQuizzesByUser($_SESSION['user_id']);
        $quiz_ids = array();
        $new_quizzes = array();
        for ($i = 0; $i < count($quizzes); $i++) {
            $id = $quizzes[$i]['id'];
            if (in_array($id, $quiz_ids)) {
                $index = array_search($id, $quiz_ids);
                array_push($new_quizzes[$index]->question_ids, $quizzes[$i]['question_id']);
                array_push($new_quizzes[$index]->questions, $quizzes[$i]['question']);
                array_push($new_quizzes[$index]->durations, $quizzes[$i]['duration']);
            } else {
                array_push($quiz_ids, $id);
                $item = new stdClass();
                $item->id = $id;
                $item->code = $quizzes[$i]['code'];
                $item->question_ids = array($quizzes[$i]['question_id']);
                $item->questions = array($quizzes[$i]['question']);
                $item->durations = array($quizzes[$i]['duration']);
                $item->total_duration = $quizzes[$i]['total_duration'];
                $item->total_duration_flag = $quizzes[$i]['total_duration_flag'];
                $new_quizzes[] = $item;
            }
        }
        require_once __DIR__ . "/../views/main/quizzes.php";
    }

    public function postManageQuizzesOwn($request)
    {
        $action = $request['action'];
        switch ($action) {
            case "add_quiz_own":
                $questions_string = $request['questions'];
                $questions = json_decode($questions_string);
                $total_duration_flag_string = $request['total_duration_flag'];
                $total_duration_flag = 0;
                $total_duration = 0;
                $durations = array();
                if ($total_duration_flag_string == "true") {
                    $total_duration_flag = 1;
                    $total_duration = $request['total_duration'];
                } else {
                    $durations_string = $request['durations'];
                    $durations = json_decode($durations_string);
                    if (count($questions) != count($durations)) {
                        echo json_encode(["status" => "error", "message" => "Failed creating a quiz from durations"]);
                        die();
                    }
                }
                $code = $this->getNewCode();
                $query_res = $this->mainModel->addQuiz($_SESSION['user_id'], $code, $questions, $durations, $total_duration, $total_duration_flag);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Created a quiz successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed creating a quiz"]);
                break;
            case "edit_quiz_own":
                $quiz_id = $request['quiz_id'];
                $questions_string = $request['questions'];
                $questions = json_decode($questions_string);
                $total_duration_flag = 0;
                $total_duration = 0;
                $durations = array();
                if ($request['total_duration_flag'] == "true") {
                    $total_duration_flag = 1;
                    $total_duration = $request['total_duration'];
                } else {
                    $durations_string = $request['durations'];
                    $durations = json_decode($durations_string);
                    if (count($questions) != count($durations)) {
                        echo json_encode(["status" => "error", "message" => "Failed creating a quiz from durations"]);
                        die();
                    }
                }
                $query_res = $this->mainModel->editQuiz($quiz_id, $questions, $durations, $total_duration, $total_duration_flag);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Updated a quiz successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed updating a quiz"]);
                break;
            case "remove_quiz_own":
                $quiz_id = $request['quiz_id'];
                $query_res = $this->mainModel->removeQuiz($quiz_id);
                if ($query_res) echo json_encode(["status" => "success", "message" => "Removed a quiz successfully"]);
                else echo json_encode(["status" => "error", "message" => "Failed removing a quiz"]);
                break;
            default:
                echo json_encode(["status" => "error", "message" => "Undefined method"]);
                break;
        }
        die();
    }

    public function manageTests()
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "tests";
        $sidebar->sub_menu = "";
        require_once __DIR__ . "/../views/main/tests.php";
    }

    public function manageTestQuiz($request)
    {
        $this->check_session();
        $base_url = $this->base_url;
        $sidebar = new stdClass();
        $sidebar->menu = "tests";
        $sidebar->sub_menu = "";
        $quiz = new stdClass();
        $code = $request['code'];
        $get_quiz = $this->mainModel->getQuizIdByCode($code);
        if (!$code || !$get_quiz) {
            $quiz->status = 0; //0: not exist, 1: enable to start, 2: started, 3: expired
        } else {
            $student_id = $_SESSION['user_id'];
            $quiz_id = $get_quiz['id'];
            $check_test = $this->mainModel->checkTestQuiz($student_id, $quiz_id);
            if ($check_test) {
                $quiz->status = 2;
            } else {
                $quiz->status = 1;
                $query_res = $this->mainModel->getQuizByCode($request['code']);
                for ($i = 0; $i < count($query_res); $i++) {
                    $item = $query_res[$i];
                    if ($i == 0) {
                        $quiz->id = $item['id'];
                        $quiz->code = $item['code'];
                        $quiz->total_duration = $item['total_duration'];
                        $quiz->total_duration_flag = $item['total_duration_flag'];
                        $quiz->question_ids = array($item['question_id']);
                        $quiz->questions = array($item['question']);
                        $answer_item = str_replace('"flag":1', '"flag":0', $item['answers']);
                        $quiz->answers = array($answer_item);
                        $quiz->durations = array($item['duration']);
                    } else {
                        array_push($quiz->question_ids, $item['question_id']);
                        array_push($quiz->questions, $item['question']);
                        $answer_item = str_replace('"flag":1', '"flag":0', $item['answers']);
                        array_push($quiz->answers, $answer_item);
                        array_push($quiz->durations, $item['duration']);
                    }
                }
                $this->mainModel->openQuiz($student_id, $quiz_id);
            }
        }
        if ($quiz->status == 1 && $quiz->total_duration_flag == 1) {
            require_once __DIR__ . "/../views/main/test_quiz.php";
        } else {
            require_once __DIR__ . "/../views/main/test_quiz_item.php";
        }
    }

    public function postTestResult($request)
    {
        $user_id = $_SESSION['user_id'];
        $action = $request['action'];
        switch ($action) {
            case "get_quiz":
                $query_res = $this->mainModel->getQuizByCode($request['code']);
                if (count($query_res) > 0) {
                    echo json_encode(["status"=>"success", "message"=>"", "count"=>count($query_res)]);
                } else {
                    echo json_encode(["status"=>"error", "message"=>"Do not exist the quiz"]);
                }
                break;
            case "submit_test_item":
                $quiz_id = $request['quiz_id'];
                $question_id = $request['question_id'];
                $answer = $request['answer'];
                $item_flag = $request['item_flag'];
                $query_res = $this->mainModel->submitItemAnswer($quiz_id, $user_id, $question_id, $answer, $item_flag);
                if ($query_res) echo json_encode(["status"=>"success", "message"=>"Submitted a test successfully"]);
                else echo json_encode(["status"=>"error", "message"=>"Failed submitting a test"]);
                break;
            case "submit_test_total":
                $quiz_id = $request['quiz_id'];
                $question_ids = json_decode($request['question_ids']);
                $answers = json_decode($request['answers']);
                $query_res = $this->mainModel->submitTotalAnswers($quiz_id, $user_id, $question_ids, $answers);
                if ($query_res) echo json_encode(["status"=>"success", "message"=>"Submitted a test successfully"]);
                else echo json_encode(["status"=>"error", "message"=>"Failed submitting a test"]);
                break;
            default:
                echo json_encode(["status"=>"error", "message"=>"Undefined method"]);
                break;
        }
        die();
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
            echo json_encode(["status" => "success", "message" => "Update account information successfully"]);
            die();
        } else if ($action == "change_password") {
            $current_password = $request["current_password"];
            $new_password = $request["new_password"];
            $user = $this->mainModel->getUser($_SESSION['user_id']);
            if (!$user) {
                echo json_encode(["status" => "error", "message" => "User is not defined"]);
                die();
            }
            if (!password_verify($current_password, $user["password"])) {
                echo json_encode(["status" => "error", "message" => "Current password is wrong"]);
                die();
            }
            $this->mainModel->updateUser($_SESSION['user_id'], null, null, $new_password, null, null, null);
            echo json_encode(["status" => "success", "message" => "Password is changed successfully"]);
            die();
        } else {
            echo json_encode(["status" => "error", "message" => "Undefined method"]);
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

    public function generateCode()
    {
        $n = 5;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        $randomString .= '-';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public function getNewCode()
    {
        $code = $this->generateCode();
        $check_code = $this->mainModel->checkCode($code);
        while ($check_code) {
            $code = $this->generateCode();
            $check_code = $this->mainModel->checkCode($code);
        }
        return $code;
    }
}
