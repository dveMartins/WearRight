<?php
class Users extends General{
    public  $user_id;
    public  $first_name;
    public  $last_name;
    public  $username;
    public  $email;
    public  $password;
    public  $user_category;
    public  $user_image;
    public  $date_registered;
    public  $about_user;
    private $signed_in;
    public  $validation_msg = array(
            "create_user_error"  => "",
            "create_user_success" => ""
    );
    
    private function get_all_users() {
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
                "about_user"      => $row['about_user'],
                "user_image"      => $row['user_image'],
                "date_registered" => $row['date_registered']
            );
            return $user_details;
        }
    }
    
    public function display_all_user_in_admin() {
        $users = $this->get_all_users();
        while($row = $users->fetch_array(MYSQLI_ASSOC)) {
        $date = $this->convert_date($row['date_registered']);
echo <<<USERS
            
    <tr class='clickable-row' data-href='single_user.php?user_id={$row['user_id']}'>
       <td>{$row['user_id']}</td>
       <td>{$row['username']}</td>
       <td>{$row['first_name']}</td>
       <td>{$row['last_name']}</td>  
       <td><img class="img-bordered img-responsive img-circle" width="65" height="80" src="../images/users/{$row['user_image']}"></td>
       <td><span class="label label-danger">{$row['user_category']}</span></td>
       <td>{$row['email']}</td>
       <td>{$date}</td> 
    </tr>   
           
USERS;
        }
    }
    
    
    /*********** Create User in Admin **************/
    
    public function create_user() {
        global $database;
        if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['user_category']) && $_POST['password'] == $_POST['cpassword']) {
        $this->first_name    = $database->escape_string($_POST['first_name']);
        $this->last_name     = $database->escape_string($_POST['last_name']);
        $this->username      = $database->escape_string($_POST['username']);
        $this->password      = $database->escape_string($_POST['password']);
        $this->user_category = $database->escape_string($_POST['user_category']);
        $this->email         = $database->escape_string($_POST['email']);
        $this->about_user    = $database->escape_string($_POST['about_user']);
        $this->user_image    = $database->escape_string($_POST['user_image']);
        
        //hash password
        $this->password = $this->encrypt_pass($this->password);
        
        if($_FILES['user_image']['error'] == 0) {        
            $this->user_image = htmlspecialchars($_FILES['user_image']['name']);
        } else {
            $this->user_image = "user-default.png";
        }
        
        $query = $database->query("INSERT INTO users (first_name, last_name, username, email, password, user_category, about_user, user_image) "
                . "VALUES ('{$this->first_name}', '{$this->last_name}', '{$this->username}', '{$this->email}', "
                . "'{$this->password}', '{$this->user_category}', '{$this->about_user}', '{$this->user_image}')");
                
        $this->validation_msg['create_user_success'] = "User successfully created";
        
        return $query;
        
        } else {
            $this->validation_msg['create_user_error'] = "Error! Please fill in the required fields correctly";
        }
        
    }
    
        
    /*********** Update Users *********************/
    
    public function update_user($row) {
        global $database;
        $this->first_name    = $database->escape_string($_POST['first_name']);
        $this->last_name     = $database->escape_string($_POST['last_name']);
        $this->username      = $database->escape_string($_POST['username']);
        $this->user_category = $database->escape_string($_POST['user_category']);
        $this->email         = $database->escape_string($_POST['email']);
//        $this->about_user    = trim($database->escape_string($_POST['about_user']));
        
        
        
        //Check for empty inputs
        
        if($_FILES['user_image']['error'] == 0) {        
            $this->user_image = htmlspecialchars($_FILES['user_image']['name']);
        } else {
            $this->user_image = $row['user_image'];
        }
        
        $empty = "";
        
        switch ($empty):
            case $_POST['first_name']:
                    $this->first_name    = $row['first_name'];
            case $_POST['last_name']:
                    $this->last_name     = $row['last_name'];
            case $_POST['username']:
                    $this->username      = $row['username'];
            case $_POST['user_category']:
                    $this->user_category = $row['user_category'];
            case $_POST['email']:
                    $this->email         = $row['email'];
                    break;
        endswitch;
        
        $query = $database->query("UPDATE users SET "
                . "first_name     = '{$this->first_name}', "
                . "last_name      = '{$this->last_name}', "
                . "username       = '{$this->username}', "
                . "user_category  = '{$this->user_category}', "
                . "email          = '{$this->email}', "
                . "about_user     = '{$database->escape_string($_POST['about_user'])}', "
                . "user_image     = '{$this->user_image}' "
                . "WHERE user_id  = '{$this->user_id}'");
                
        return $query;
    }
    
    
     /************** Delete Users *******************/
    
    public function delete_user() {
        global $database;
        $query = $database->query("DELETE FROM users WHERE user_id = {$this->user_id}");
        return $query;
    }
 
    
}

