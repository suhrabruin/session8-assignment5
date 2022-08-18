<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login-styles.css">
</head>
<body>
    <?php  
    

    require_once 'includes/core.php';    
    require_once 'classes/user.php';    
    if(User::is_login()){
        redirect('dashboard.php');
    }
    ?>
    <div class="login">
        <h3>Login</h3>
        <p>
            username: suhrab
            password: 1
        </p>
        <form action="login_controller.php" method="post" id="login-form">
            <label for="username">Username:</label>
            <input class="login-input" type="text" name="username" placeholder="Username"/><br/>
            <label for="username">Password:</label>
            <input class="login-input" type="password" name="password" placeholder="Password"/><br/>
            <input type="submit" name="login" value="Login"/>
            <p class="links">
                <a href="signup.php">Signup</a>
                <a href="forgot_password.php" style="margin-left:50px;">Forgot Password</a>
            </p>
        </form>
        <p class="error"><?php echo get_message('error');?></p>
        <p class="success"><?php echo get_message('success');?></p>
    </div>
</body>
</html>