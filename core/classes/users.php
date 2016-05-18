<?php
class Users extends General{
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $user_category;
    public $user_image;
    
    protected function get_all_users() {
        global $database;
        return $database->query("SELECT * FROM users");
    }
    
    public function login_user() {
        $query = $this->get_all_users();
        while($users = $query->fetch_array(MYSQLI_ASSOC)) {
            if($this->username == $users['username'] && $this->password == $users['password']) {
                echo "<h4 class='alert alert-success'>Welcome " .ucfirst($this->username). "</h4>";
            } else {
                echo "<h4 class='alert alert-danger'>Error! Please check your details. </h4>";
            }
        }
    }
}

