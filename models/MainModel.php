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
        mysqli_close($this->conn);
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
        $query_res = mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
        return $query_res;
    }

    public function removeMainCategory($id)
    {
        $sql = "delete from categories where id=" . $id;
        $query_res = mysqli_query($this->conn, $sql);
        if ($query_res) {
            $sub_sql = "delete from sub_categories where category_id=" . $id;
            mysqli_query($this->conn, $sub_sql);
        }
        mysqli_close($this->conn);
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
        $query_res = mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
        return $query_res;
    }

    public function removeSubCategory($id)
    {
        $sql = "delete from sub_categories where id=" . $id;
        $query_res = mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
        return $query_res;
    }

    public function getAllQuestions()
    {
        $sql = "select A.id, A.question, A.answers, B.id as user_id, B.name as user_name, B.email as user_email, C.id as category_id, C.name as category_name, SC.id as sub_id, SC.name as sub_name from questions as A left join users as B on A.user_id = B.id left join categories as C on A.category_id = C.id left join sub_categories as SC on A.sub_category_id = SC.id";
        $query_res = mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
        return $query_res->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuestionsByUser($user_id)
    {
        $sql = "select A.id, A.question, A.answers, B.id as user_id, B.name as user_name, B.email as user_email, C.id as category_id, C.name as category_name, SC.id as sub_id, SC.name as sub_name from questions as A left join users as B on A.user_id = B.id left join categories as C on A.category_id = C.id left join sub_categories as SC on A.sub_category_id = SC.id where user_id = " . $user_id;
        $query_res = mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
        return $query_res->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuestionsById($id)
    {
        $sql = "select A.id, A.question, A.answers, B.id as user_id, B.name as user_name, B.email as user_email, C.id as category_id, C.name as category_name, SC.id as sub_id, SC.name as sub_name from questions as A left join users as B on A.user_id = B.id left join categories as C on A.category_id = C.id left join sub_categories as SC on A.sub_category_id = SC.id where user_id = " . $id . " limit 1";
        $select = mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
        return $select->fetch_assoc();
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
        $query_res = mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
        return $query_res;
    }

    public function removeQuestion($id)
    {
        $sql = "delete from questions where id=" . $id;
        $query_res = mysqli_query($this->conn, $sql);
        mysqli_close($this->conn);
        return $query_res;
    }

    public function getAllQuizzes()
    {

    }
}