<?php
// code source: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
// Include config file
define('BASEPATH',true);
require_once "Config.php";
if (isset($_POST['submit'])){
    try{
        $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        //echo "create dsn";
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_POST['username'];
        $password = $_POST['password'];

        // 
        $password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

        $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
        //echo "\nsql asked";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':username',$username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // echo "row :".$row['num'];
        if($row['num'] > 0){
            echo '<script>alert("Username already exists");</script>';
        }else{
            // insert new user account
            $stmt = $dsn->prepare("INSERT INTO users(username, password) 
            VALUES(:username,:password)"
            );
            $stmt->bindParam(':username', $username);
            $stmt -> bindParam(':password',$password);
            echo "stmt bind password";
            if($stmt->execute()){
                echo '<script>alert("Registration Successful");</script>';
                echo '<script>window.location.replace("Login.php")</script>';
            }else{
                $error = "Error: ".$e->getMessage();
                echo '<script>alert("w");</script>';
            }

        }
    
    }catch(PDOException $e){
        $error = "Error: ".$e->getMessage();
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="Registration.php" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control">
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="Login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>