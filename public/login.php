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
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>New User Signup!</h2>
                    <form action="#">
                        <input type="text" placeholder="Name"/>
                        <input type="email" placeholder="Email Address"/>
                        <input type="password" placeholder="Password"/>
                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->
<?php include 'includes/footer.php';


