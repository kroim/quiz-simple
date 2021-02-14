<?php

class MainModel
{
    private $conn = null;

    public function __construct()
    {
        $db = new Database();
        if (!$db->_init()) {
            die("DB Connection failed");
        }
        $this->conn = $db->connection();
    }

    public function getUser($id)
    {
        $sql = "select * from users where id=" . $id . " limit 1";
        $select = mysqli_query($this->conn, $sql);
        if ($row = $select->fetch_assoc()) {
            return $row;
        } else return null;
    }

    public function getUsers($type)
    {
        $sql = "";
        if ($type == 2 || $type == 3) {
            $sql = "select * from users where role=" . $type;
        } else {
            $sql = "select * from users where not role=1";
        }
        $selects = mysqli_query($this->conn, $sql);
        return $selects->fetch_all(MYSQLI_ASSOC);
    }

    public function updateUser($id, $name = null, $email = null, $password = null, $role = null, $description = null, $avatar = null)
    {
        $updated_at = date("Y-m-d H:i:s");
        $sql = "update users set updated_at='" . $updated_at . "'";
        if ($name) $sql .= ", name='" . $name . "'";
        if ($email) $sql .= ", email='" . $email . "'";
        if ($password) $sql .= ", password='" . password_hash($password, PASSWORD_DEFAULT) . "'";
        if ($description) $sql .= ", description='" . $description . "'";
        if ($role) $sql .= ", role=" . $role;
        if ($avatar) $sql .= ", avatar='" . $avatar . "'";
        $sql .= " where id=" . $id;
        mysqli_query($this->conn, $sql);
    }

    public function logout($email)
    {
        $sql = "update users set login_status = 0 where email='" . $email . "'";
        mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
    }

    public function getCategories()
    {
        $sql = "select * from categories";
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_all(MYSQLI_ASSOC);
    }

    public function getSubCategories()
    {
        $sql = "select A.id, A.name, B.id as category_id, B.name as category_name from sub_categories as A left join categories as B on A.category_id = B.id";
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_all(MYSQLI_ASSOC);
    }

    public function addMainCategory($name)
    {
        $sql = "insert into categories (name) values ('" . $name . "')";
        return mysqli_query($this->conn, $sql);
    }

    public function editMainCategory($id, $name)
    {
        $sql = "update categories set name='" . $name . "' where id=" . $id;
        return mysqli_query($this->conn, $sql);
    }

    public function removeMainCategory($id)
    {
        $sql = "delete from categories where id=" . $id;
        $query_res = mysqli_query($this->conn, $sql);
        if ($query_res) {
            $sub_sql = "delete from sub_categories where category_id=" . $id;
            mysqli_query($this->conn, $sub_sql);
        }
        return $query_res;
    }

    public function addSubCategory($name, $category)
    {
        $sql = "insert into sub_categories (name, category_id) values ('" . $name . "', " . $category . ")";
        return mysqli_query($this->conn, $sql);
    }

    public function editSubCategory($id, $name, $parent)
    {
        $sql = "update sub_categories set name='" . $name . "', category_id=" . $parent . " where id=" . $id;
        return mysqli_query($this->conn, $sql);
    }

    public function removeSubCategory($id)
    {
        $sql = "delete from sub_categories where id=" . $id;
        return mysqli_query($this->conn, $sql);
    }

    public function getAllQuestions()
    {
        $sql = "select A.id, A.question, A.answers, B.id as user_id, B.name as user_name, B.email as user_email, C.id as category_id, C.name as category_name, SC.id as sub_id, SC.name as sub_name from questions as A left join users as B on A.user_id = B.id left join categories as C on A.category_id = C.id left join sub_categories as SC on A.sub_category_id = SC.id";
        $query_res = mysqli_query($this->conn, $sql);
        return $query_res->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuestionsByUser($user_id)
    {
        $sql = "select A.id, A.question, A.answers, B.id as user_id, B.name as user_name, B.email as user_email, C.id as category_id, C.name as category_name, SC.id as sub_id, SC.name as sub_name from questions as A left join users as B on A.user_id = B.id left join categories as C on A.category_id = C.id left join sub_categories as SC on A.sub_category_id = SC.id where user_id = " . $user_id;
        $query_res = mysqli_query($this->conn, $sql);
        return $query_res->fetch_all(MYSQLI_ASSOC);
    }

    public function createQuestion($user_id, $category, $sub_category, $question, $answer)
    {
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
        $sql = "insert into questions (user_id, category_id, sub_category_id, question, answers, created_at, updated_at) values ("
            . $user_id . ", " . $category . ", " . $sub_category . ", '" . $question . "', '" . $answer . "', '" . $created_at . "', '" . $updated_at . "')";
        return mysqli_query($this->conn, $sql);
    }

    public function updateQuestion($id, $category, $sub_category, $question, $answer)
    {
        $updated_at = date("Y-m-d H:i:s");
        $sql = "update questions set category_id='" . $category . "', sub_category_id=" . $sub_category . ", question='" . $question
            . "', answers='" . $answer . "', updated_at='" . $updated_at . "' where id=" . $id;
        return mysqli_query($this->conn, $sql);
    }

    public function removeQuestion($id)
    {
        $sql = "delete from questions where id=" . $id;
        return mysqli_query($this->conn, $sql);
    }

    public function getAllQuizzes()
    {
        $sql = "select A.id, A.code, C.id as question_id, C.question as question, B.duration as duration, A.total_duration, A.total_duration_flag from quizzes as A left join quiz_question as B on A.id = B.quiz_id left join questions as C on B.question_id = C.id order by id ASC";
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuizByCode($code)
    {
        $sql = "select A.id, A.code, C.id as question_id, C.question as question, C.answers as answers, B.duration as duration, A.total_duration, A.total_duration_flag from quizzes as A left join quiz_question as B on A.id = B.quiz_id left join questions as C on B.question_id = C.id where A.code = '" . $code . "'";
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuizIdByCode($code)
    {
        $sql = "select * from quizzes where code='" . $code . "'";
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_assoc();
    }

    public function checkTestQuiz($student_id, $quiz_id)
    {
        $sql = "select * from tests where student_id=" . $student_id . " and quiz_id=" . $quiz_id;
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_assoc();
    }

    public function getQuizzesByUser($user_id)
    {
        $sql = "select A.id, A.code, A.activate_duration, C.id as question_id, C.question as question, B.duration as duration, A.total_duration, A.total_duration_flag from quizzes as A left join quiz_question as B on A.id = B.quiz_id left join questions as C on B.question_id = C.id where A.user_id = " . $user_id . " order by id ASC";
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_all(MYSQLI_ASSOC);
    }

    public function addQuiz($user_id, $code, $questions, $durations, $total_duration, $total_duration_flag, $activate_duration)
    {
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
        $sql = "insert into quizzes (user_id, code, total_duration, total_duration_flag, activate_duration, created_at, updated_at) values (" . $user_id . ", '" . $code . "', '" . $total_duration . "', " . $total_duration_flag . ", '" . $activate_duration . "', '" . $created_at . "', '" . $updated_at . "')";
        mysqli_query($this->conn, $sql);
        $insert_id = mysqli_insert_id($this->conn);
        if ($insert_id >= 0) {
            $sql1 = "insert into quiz_question (quiz_id, question_id, duration) values ";
            for ($i = 0; $i < count($questions); $i++) {
                if ($i > 0) $sql1 .= ", ";
                if (!$total_duration_flag) {
                    $sql1 .= "(" . $insert_id . ", " . $questions[$i] . ", '" . $durations[$i] . "')";
                } else $sql1 .= "(" . $insert_id . ", " . $questions[$i] . ", 0)";
            }
            return mysqli_query($this->conn, $sql1);
        } else return false;
    }

    public function editQuiz($id, $questions, $durations, $total_duration, $total_duration_flag, $activate_duration)
    {
        $updated_at = date("Y-m-d H:i:s");
        $sql = "update quizzes set total_duration='" . $total_duration . "', total_duration_flag=" . $total_duration_flag . ", activate_duration='" . $activate_duration . "', updated_at='" . $updated_at . "' where id=" . $id;
        $query_res = mysqli_query($this->conn, $sql);
        if ($query_res) {
            $sql_remove = "delete from quiz_question where quiz_id=" . $id;
            mysqli_query($this->conn, $sql_remove);
            $sql_add = "insert into quiz_question (quiz_id, question_id, duration) values ";
            for ($i = 0; $i < count($questions); $i++) {
                if ($i > 0) $sql_add .= ", ";
                if (!$total_duration_flag) {
                    $sql_add .= "(" . $id . ", " . $questions[$i] . ", '" . $durations[$i] . "')";
                } else $sql_add .= "(" . $id . ", " . $questions[$i] . ", 0)";
            }
            return mysqli_query($this->conn, $sql_add);
        } else return false;
    }

    public function removeQuiz($id) {
        $sql = "delete from quizzes where id='" . $id . "'";
        $query_res = mysqli_query($this->conn, $sql);
        if ($query_res) {
            $sql1 = "delete from quiz_question where quiz_id=".$id;
            return mysqli_query($this->conn, $sql1);
        } else return false;
    }

    public function checkCode($code)
    {
        $sql = "select * from quizzes where code='" . $code . "'";
        $select = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($select)) return true;  // exist code already
        return false;  // don't exist code
    }

    public function openQuiz($student_id, $quiz_id)
    {
        $check_sql = "select * from tests where student_id = " . $student_id . " and quiz_id = " . $quiz_id;
        $select = mysqli_query($this->conn, $check_sql);
        if (mysqli_num_rows($select)) return false;
        else {
            $start_time = date("Y-m-d H:i:s");
            $sql = "insert into tests (student_id, quiz_id, start_time, status) values (" . $student_id . ", " . $quiz_id . ", '" . $start_time . "', 2)";
            return mysqli_query($this->conn, $sql);
        }
    }

    public function submitTotalAnswers($quiz_id, $student_id, $question_ids, $answers)
    {
        $check_sql = "select * from tests where student_id = " . $student_id . " and quiz_id = " . $quiz_id;
        $select = mysqli_query($this->conn, $check_sql);
        if (mysqli_num_rows($select)) {
            $test = $select->fetch_assoc();
            $end_time = date("Y-m-d H:i:s");
            $update_sql = "update tests set status = 3, end_time ='" . $end_time . "' where id = " . $test['id'];
            $update_res = mysqli_query($this->conn, $update_sql);
            if ($update_res) {
                $insert_sql = "insert into answers (test_id, question_id, answers, status) values ";
                for ($i = 0; $i < count($question_ids); $i++) {
                    if ($i > 0) $insert_sql .= ", ";
                    $insert_sql .= "(" . $test['id'] . ", " . $question_ids[$i] . ", '" . json_encode($answers[$i]) . "', 0)";
                }
                return mysqli_query($this->conn, $insert_sql);
            } else return false;
        } else return false;
    }

    public function submitItemAnswer($quiz_id, $student_id, $question_id, $answer, $item_flag)
    {
        $check_sql = "select * from tests where student_id = " . $student_id . " and quiz_id = " . $quiz_id;
        $select = mysqli_query($this->conn, $check_sql);
        if (mysqli_num_rows($select)) {
            $test = $select->fetch_assoc();
            $end_time = date("Y-m-d H:i:s");
            $status = 2;
            if ($item_flag == '1') $status = 3;
            $update_sql = "update tests set status = " . $status . ", end_time ='" . $end_time . "' where id = " . $test['id'];
            $update_res = mysqli_query($this->conn, $update_sql);
            if ($update_res) {
                $insert_sql = "insert into answers (test_id, question_id, answers, status) values (" . $test['id'] . ", " . $question_id . ", '" . $answer . "', 0)";
                return mysqli_query($this->conn, $insert_sql);
            } else return false;
        } else return false;
    }

    public function getAllTests()
    {
        $sql = "select A.id, D.name, D.email, C.question, B.answers from tests as A left join answers as B on A.id = B.test_id left join questions as C on B.question_id = C.id left join users as D on A.student_id = D.id";
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_all(MYSQLI_ASSOC);
    }

    public function getTestsByTeacher($teacher_id)
    {
        $sql = "select A.id, D.name, D.email, C.question, B.answers from tests as A left join answers as B on A.id = B.test_id  "
            . "left join questions as C on B.question_id = C.id left join users as D on A.student_id = D.id left join quizzes as E on A.quiz_id = E.id "
            . "where E.user_id = " . $teacher_id;
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_all(MYSQLI_ASSOC);
    }

    public function getTestsByStudent($student_id)
    {
        $sql = "select A.id, C.question, B.answers from tests as A left join answers as B on A.id = B.test_id left join questions as C on B.question_id = C.id where A.student_id = " . $student_id;
        $select = mysqli_query($this->conn, $sql);
        return $select->fetch_all(MYSQLI_ASSOC);
    }
}