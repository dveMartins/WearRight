<?php include 'includes/header.php'; ?>	
<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <?php 
                $users = new Users();
                
                if(isset($_POST['login'])) {
                    
                   $users->username = $database->escape_string($_POST['username']);
                   $users->password = $database->escape_string($_POST['password']);
                   
                   $users->login_user();
                   
                }
                ?>
                <div class="login-form"><!--login form-->
                    <h2>Login to your account</h2>
                    <form action="login.php" method="post">
                        <input type="text" name="username" placeholder="Username" />
                        <input type="password" name="password" placeholder="Password" />
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Keep me signed in
                        </span>
                        <button type="submit" name="login" class="btn btn-default">Login</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-6">
                <?php
                
                if(isset($_POST['register'])):
                    $login_data = array (
                        "first_name" => $database->escape_string($_POST['first_name']),
                        "last_name"  => $database->escape_string($_POST['last_name']),
                        "username"   => $database->escape_string($_POST['username']),
                        "email"      => $database->escape_string($_POST['email']),
                        "password"   => $database->escape_string($_POST['password']),
                        "cpassword"  => $database->escape_string($_POST['cpassword']),
                        "tmp_name"   => htmlspecialchars($_FILES['user_image']['tmp_name']),
                        "user_image" => htmlspecialchars($_FILES['user_image']['name'])                
                    );
                 if($users->register_user($login_data)) {
                     $target_dir = "images/users/";
                     $target_file = $target_dir . basename($login_data["user_image"]);
                     move_uploaded_file($login_data["tmp_name"], $target_file);
                     echo "<h4 class='alert alert-success'>User Successfully Created! Please login to continue </h4>";
                 }
                    
                endif;
                
                ?>
                <div class="signup-form"><!--sign up form-->
                    <h2>New User Signup!</h2>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="first_name" placeholder="First Name"/>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="last_name" placeholder="Last Name"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7">
                                <input type="text" name="username" placeholder="Username"/>
                            </div>
                            <div class="col-sm-5">
                                <input type="file" name="user_image"/>
                            </div>
                        </div>
                        <input type="email" name="email" placeholder="Email"/>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="password" name="password" placeholder="Password"/>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" name="cpassword" placeholder="Confirm Password"/>
                            </div>
                        </div>
                        <button type="submit" name="register" class="btn btn-default">Signup</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->
<?php include 'includes/footer.php';


