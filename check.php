<?php
	/*try {
		$conn = new PDO("sqlsrv:server = tcp:gddv.database.windows.net,1433; Database = sm", "sm", "{Your password}");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		print("Error connecting to SQL Server.");
		die(print_r($e));
	}

	// SQL Server Extension Sample Code:
	$connectionInfo = array("UID" => "sm@gddv", "pwd" => "{Your password}", "Database" => "sm", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
	$serverName = "gddv.database.windows.net,1433";
	$conn = sqlsrv_connect($serverName, $connectionInfo); */
	
	// Input Errors
	$error = "";
	if (!preg_match("/^[a-zA-Z ]*$/",$_POST["firstname"])) {
		$error .= "Invalid first name format<br>";
	}
	
	if (!preg_match("/^[a-zA-Z ]*$/",$_POST["lastname"])) {
		$error .= "Invalid last name format<br>";
	}
	
	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$error .= "Invalid email format<br>";
	}
	
	/* Check nickname available
	$sql = "SELECT Nickname FROM Usuaris WHERE Nickname = '".$_POST["nick"]."';";
	$stmt = sqlsrv_query($conn, $sql);
	if (sqlsrv_num_rows($stmt) > 0) {
		$error .= "This nickname is already in use!<br>";
	}*/
	
	$pwd = $_POST["password"];
	if (strcmp($pwd, $_POST["repassword"]) != 0) {
		$error .= "Passwords didn't match!<br>";
	}
	
	if (strlen($pwd) < 8) {
		$error .= "Password too short<br>";
	}
	
	if (!preg_match("#[0-9]+#", $pwd)) {
        $error .= "Password must include at least one number<br>";
    }
	
	if (!preg_match("#[a-z]+#", $pwd)) {
        $error .= "Password must include at least one lowercase letter<br>";
    }
	
	if (!preg_match("#[A-Z]+#", $pwd)) {
        $error .= "Password must include at least one uppercase letter!";
    }
	
	if ($error == "") {
		// Encripting password
		$res = "";
		for ($pos=0; $pos < strlen($_POST["nick"]); $pos ++) {
			$byte = substr($_POST["nick"], $pos);
			$res += ord($byte) * (pos + 1);
		}
		srand($res);
		
		$newpass = array();
		for ($pos=0; $pos < strlen($_POST["password"]); $pos ++) {
			$byte = substr($_POST["password"], $pos);
			$res = chr(($byte * rand()) % 256);
			array_push($newpass, $res);
		}
		
		$pass = implode("", $newpass);
		echo $pass;
		
		/* Making Insert on Database
		$sql = "INSERT INTO Usuaris VALUES ('".$_POST["firstname"]."', '".$_POST["lastname"]."', '".$_POST["email"]."', ".$_POST["age"].", '".$_POST["nick"]."', '".$pass."', '');";
		$stmt = sqlsrv_query($conn, $sql);
		if( $stmt === false ) {
			$error = "We can't make the register";
		}
		else {
			/* Send mail 
		}*/
	} 
	
	echo '<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
			<meta name="viewport" content="width=device-width, initial-scale=1">';
			if ($error == "") {
				echo "<title>User succesfull registered!</title>";
				echo '<meta http-equiv="REFRESH" content="5"; url=index.php">';
			}
			else {
				echo "<title>Invalid data</title>";
				echo '<meta http-equiv="REFRESH" content="5"; url=register.php">';
			}
		echo '</head>
		<body>';
			if ($error == "") {
				echo "User ".$_POST["nick"]." succesfully registered!";
				echo '<br><br><form action="index.php">
					<input type="submit" value="Go to Log in" />
				</form><hr>';
			}
			else {
				echo $error;
				echo '<br><br><form action="register.php">
					<input type="submit" value="<- Back" />
				</form><hr>';
			}
		echo '</body>
	</html>';
?>
