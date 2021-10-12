<?php
session_start();
define('BASEPATH',true);
require 'Config.php';

$_SESSION['username'] = '';

if (isset($_POST['submit'])){
    try{
        $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        //echo "create dsn";
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //ensure fields are not empty
        $user_login = !empty($_POST['username']) ? ($_POST['username']) :null;
        $passwordAttempt = !empty($_POST['password']) ? ($_POST['password']) :null;
        
        // Retrieve 
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        echo '\nprepare sql';
        $stmt->bindValue(':username',$user_login);
        echo "\nuser_login".$user_login;
        echo "\npasswordAttempt".$passwordAttempt;
        // Executes
        $stmt->execute();

        // Fetch
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "\nuser['password']".$user['password'];
        //If row is false
        if($user === false){
            echo '<script>alert("user false: invalid username or password")</script>';
        }else{
            // Compare passwords
            echo "\ncompare password";
            $validPassword = 
            password_verify($passwordAttempt, $user['password']);

            if($validPassword){
                echo "session[username]".$_SESSION['username'];
                $_SESSION['username'] = $user_login;
                echo '<script>window.location.replace("Welcome.php")</script>';
            }else{
                echo '<script>alert("invalid username or password")</script>';
            }
        }
    }catch(PDOException $e){
        $error = "Error: " . $e->getMessage();
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
    }

}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="Login.php" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control">
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <button name="submit" type="submit">sign in</button>
                <!--input type="submit" class="btn btn-secondary ml-2" value="Login"-->
            </div>
            <p>Don't have an account? <a href="Registration.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>