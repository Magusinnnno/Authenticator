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
	?>
</html> 
