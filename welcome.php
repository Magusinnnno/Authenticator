<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//connectar-se a bdd, si hi ha una sessió oberta agafar les dades, sino crear-la
// Include config file
require_once "config.php";

$latency = number_format(microtime(true) - $_SESSION["timestamp"], 4);
$sql = "UPDATE users SET latency = " . $latency . " WHERE id = " . $_SESSION['id'];
if ($stmt = mysqli_prepare($link, $sql)) {
	if (mysqli_stmt_execute($stmt)) {
		echo "<div class='wrapper'> Your password has been seen ". $_SESSION["pwnedTimes"] ." times before </div>";
	}
	else {
		header("location: login.php");
	}
}

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
        <a href="game.php" class="btn btn-primary">ENTER THE GAME</a>
        </div>
        
        <div class="form-group">
        <a href="reset.php" class="btn btn-default">Change password</a>
        </div>
        <div class="form-group">
        <a href="logout.php" class="btn btn-default">Logout</a>
        </div>
        
    </div>    
</body>
</html>