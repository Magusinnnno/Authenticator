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
	<head>
		<title>Sign in with your account and password</title>
	</head>
	<body>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			Username:<br>
			<input type="text" name="user"><br>
			Password:<br>
			<input type="text" name="pass"><br>
			<input type="submit" name="submit" value="Submit">  
		</form>
	</body>
</html> 
