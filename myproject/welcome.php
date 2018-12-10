<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

echo "<div class='wrapper'> Your password has been seen ". $_SESSION["pwnedTimes"] ." times before </div>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Welcome</h1>
        <p>You're connected to the server</p>
        <div class="form-group">
        <a href="reset.php" class="btn btn-default">Change password</a>
        </div>
        <div class="form-group">
        <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
        
    </div>    
</body>
</html>