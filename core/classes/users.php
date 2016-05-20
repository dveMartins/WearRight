<?php
class Users extends General{
    public  $first_name;
    public  $last_name;
    public  $username;
    public  $email;
    public  $password;
    public  $user_category;
    public  $user_image;
    public  $date_registered;
    private $signed_in;
    
    protected function get_all_users() {
        global $database;
        return $database->query("SELECT * FROM users");
    }
    
    public function show_users_dashboard() {
        $users = $this->get_all_users();
        while ($row = $users->fetch_array(MYSQLI_ASSOC)):
            $this->user_image      = $row['user_image'];
            $this->first_name      = $row['first_name'];
            $this->last_name       = $row['last_name'];
            $this->date_registered = $row['date_registered'];
echo <<<USER
    <li>
        <img class="img-responsive" src="../images/users/$this->user_image" alt="$this->user_image" height="90" width="80">
        <a class="users-list-name" href="#">$this->first_name $this->last_name</a>
        <span class="users-list-date">$this->date_registered</span>
    </li>       
USER;
        endwhile;
    }
    
    private function encrypt_pass($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    private function verify_user($hash) {
        return password_verify($this->password, $hash);
    }
    
    private function validate_user() {
        global $database;
        $query1 = $database->query("SELECT * FROM users WHERE username = '{$this->username}' LIMIT 1");
        if($query1) {
        while($users = $query1->fetch_array(MYSQLI_ASSOC)) :
            if($this->username == $users['username'] && $this->password == $this->verify_user($users['password'])) { 
            
                $_SESSION['user_id'] = $users['user_id'];
                $this->redirect('../public/admin');
                echo "<h4 class='alert alert-success'>Welcome " .ucfirst($this->username). "</h4>";
            return $_SESSION['user_id'];
            } 
        endwhile;
        }
        
    }
    
    public function login_user() {
        if(!empty($this->username) && !empty($this->password)) {
            if($this->validate_user()) {
            $this->signed_in = true;
            } else {
                echo "<h4 class='alert alert-danger'>Error! Please check your details and try again.</h4>";
            }
        } else {
            echo "<h4 class='alert alert-danger'>Field(s) cannot be empty </h4>"; 
        }
    }
    
    public function logout() {
        unset($_SESSION['user_id']);
        $this->signed_in = false;
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], 
                    $params["domain"], $params["secure"], $params["httponly"]
            );
        }

        return session_destroy();
    }
    
    public function register_user($login_data) {
        global $database;  
        $encrypted_pass = $this->encrypt_pass($login_data['password']);
        $empty = array_filter($login_data);
        if(empty($empty) || empty($login_data['password']) || empty($login_data['email']) || $login_data['password'] !== $login_data['cpassword']) {
            echo "<h4 class='alert alert-danger'>Please fill in the form correctly</h4>";
        } else {
            $query = $database->query("INSERT INTO users "
                    . "(first_name, last_name, username, email, password, user_category, user_image) "
                    . "VALUES ('{$login_data['first_name']}', '{$login_data['last_name']}', '{$login_data['username']}',"
                    . "'{$login_data['email']}', '{$encrypted_pass}', 'subscriber', '{$login_data['user_image']}')");
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

