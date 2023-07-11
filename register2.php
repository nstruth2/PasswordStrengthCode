<!DOCTYPE html>
<html lang="en">
<head>
<title>Register Page</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
<form method="post" action="" name="signup-form">
<div class="form-element">
<label style="color: white">Username</label>
<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
</div>
<div class="form-element">
<label style="color: white; padding-right: 2px">Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
<input type="email" name="email" required />
</div>
<div class="form-element">
<label style="color: white; padding-right: 3px">Password</label>
<input type="password" name="password" required />
</div>
<button type="submit" name="register" value="register">Register</button>
</form>
<a href="login2.php" class="btn btn-info btn-lg">
<span class="glyphicon glyphicon-log-in"></span> Log in
</a>
<a href="index2.php">Main Page</a>
<?php
session_start();
include('config.php');
if (isset($_POST['register'])) {
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$err = "";
             
                if (strlen($password) < 8) {
                    
                    $err .= "Password must be at least 8 characters long!<br>";

                }

                if (strlen($password) > 34) {
                    
                    $err .= "Password can be 34 characters maximum!<br>";

                }

                if (!preg_match("/[0-9][A-Z]/", $password)) {
                    
                    $err .= "Password must contain a number and at least one uppercase letter in it!<br>";

                }

                    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*_)(?=.*[^a-zA-Z0-9]).{8,16}$/", $password)) {
                        
                        $err .= "Password not strong enough!";

                    }

                
                if (!$err == "") {
            
            echo 
            '<div class="col-md-12">
            <br>
            <div class="alert alert-danger" role="alert">
            '.$err.'
            </div>
            </div>';

        }else{
$password_hash = password_hash($password, PASSWORD_BCRYPT);
$query = $connection->prepare("SELECT * FROM users WHERE email=:email");
$query->bindParam("email", $email, PDO::PARAM_STR);
$query->execute();
if ($query->rowCount() > 0) {
echo '<p class="error">The email address is already registered!</p>';
}
if ($query->rowCount() == 0) {
$query = $connection->prepare("INSERT INTO users(username,password,email) VALUES (:username,:password_hash,:email)");
$query->bindParam("username", $username, PDO::PARAM_STR);
$query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
$query->bindParam("email", $email, PDO::PARAM_STR);
$result = $query->execute();
if ($result) {
echo '<p class="success">Your registration was successful!</p>';
} else {
echo '<p class="error">Something went wrong!</p>';
}
}
}
}
?>
</body>
</html>