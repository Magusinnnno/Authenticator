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
		
		// Buscar usuari a la base de dades i comparar contrasenyes
		
		if (true) { // si el login es correcte
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
