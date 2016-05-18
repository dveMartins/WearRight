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
        global $database;
        $query = $this->get_all_users();
        while($users = $query->fetch_array(MYSQLI_ASSOC)) {
            $query2  = $database->query("SELECT * FROM users WHERE username = '{$users['username']}' AND password = '{$users['password']}'");
            if($query2) {
                while($row = $query2->fetch_array(MYSQLI_ASSOC)):
                $_SESSION['user_id'] = $row['user_id'];
                $this->redirect('../public/admin');
                echo "<h4 class='alert alert-success'>Welcome " .ucfirst($this->username). "</h4>";
                endwhile;
            } else {
                echo "<h4 class='alert alert-danger'>Error! Please check your details. </h4>";                
            }              
        }
    }
    
    public function get_user_info_by_id($user_id) {
        global $database;
        $query = $database->query("SELECT * FROM users WHERE user_id = $user_id");
        while($row = $query->fetch_array(MYSQLI_ASSOC)) {
            $user_details = array(
                "first_name"      => $row['first_name'],
                "last_name"       => $row['last_name'],
                "username"        => $row['username'],
                "email"           => $row['email'],
                "password"        => $row['password'],
                "user_category"   => $row['user_category'],
                "user_image"      => $row['user_image'],
                "date_registered" => $row['date_registered']
            );
            return $user_details;
        }
    }
}

