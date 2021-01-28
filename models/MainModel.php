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

    public function getUsers($type) {
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

    public function addSubCategory($name, $category)
    {
        $sql = "insert into sub_categories (name, category_id) values ('" . $name . "', " . $category. ")";
        return mysqli_query($this->conn, $sql);
    }
}