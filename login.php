<!DOCTYPE html>
<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
	</head>
	<?php
		$userErr = $passErr = "";
		$user = $pass = "";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST["user"])) {
				$userErr = "User camp is empty";
			} else {
				$user = test_input($_POST["user"]);
			}
			if (empty($_POST["pass"])) {
				$passErr = "Password camp is empty";
			} else {
				$pass = test_input($_POST["pass"]);
			}
		}
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
		// Buscar usuari a la base de dades i agafar contrasenya encriptada $savedPass
		
		// Encripting password
		$res = "";
		for ($pos=0; $pos < strlen($user); $pos ++) {
			$byte = substr($user, $pos);
			$res += ord($byte) * (pos + 1);
		}
		srand($res);
		
		$newpass = array();
		for ($pos=0; $pos < strlen($pass); $pos ++) {
			$byte = substr($pass, $pos);
			$res = chr(($byte * rand()) % 256);
			array_push($newpass, $res);
		}
		
		$checkPass = implode("", $newpass);
	
		if (strcmp($checkPass, $savedPass) == 0) { // si el login es correcte
			setcookie("user", $user, time() + (86400 * 30), "/");
			setcookie("pass", $pass, time() + (86400 * 30), "/");
			echo "Hello " . $user . "<br>";
		}
		else {
			echo "Invalid user or password<br>";
		}
	?>
	<body>
		<a href="index.php">Go back</a>
	</body>
</html> 
