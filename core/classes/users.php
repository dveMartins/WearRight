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
        if(!empty($this->username) && !empty($this->password)) {
            while($users = $query->fetch_array(MYSQLI_ASSOC)) :
                $query2  = $database->query("SELECT * FROM users WHERE username = '{$this->username}' AND password = '{$this->password}' LIMIT 1");
                if($query2) {
                    while($row = $query2->fetch_array(MYSQLI_ASSOC)):
                    $_SESSION['user_id'] = $row['user_id'];
                    $this->redirect('../public/admin');
                    echo "<h4 class='alert alert-success'>Welcome " .ucfirst($this->username). "";
                    endwhile;
                } else {
                    echo "<h4 class='alert alert-danger'>Error! Please check your details. </h4>";                
                }              
            endwhile;
        } else {
                    echo "<h4 class='alert alert-danger'>Fields cannot be empty </h4>";                
        }
    }
    
    public function register_user($login_data) {
        global $database;      
        $empty = array_filter($login_data);
        if(empty($empty) || empty($login_data['password']) || empty($login_data['email']) || $login_data['password'] !== $login_data['cpassword']) {
            echo "<h4 class='alert alert-danger'>Please fill in the form correctly</h4>";
        } else {
            $query = $database->query("INSERT INTO users (first_name, last_name, username, email, password, user_category, user_image) "
                    . "VALUES ('{$login_data['first_name']}', '{$login_data['last_name']}', '{$login_data['username']}',"
                    . "'{$login_data['email']}', '{$login_data['password']}', 'subscriber', '{$login_data['user_image']}')");
            return $query;
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

