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

			<div class="container">
				<label for="uname"><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="uname" required>

				<label for="psw"><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="psw" required>

				<button type="submit">Login</button>
			</div>

			<div class="container" style="background-color:#f1f1f1">
				<span class="psw">Forgot <a href="#">password?</a></span>
			</div> 
		</form>
	</body>
</html> 
