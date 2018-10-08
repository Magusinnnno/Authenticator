<!DOCTYPE html>
<html>
	<?php
		$user = $pass = "";
		if(isset($_COOKIE["user"])) {
			$user = $_COOKIE["user"];
		}
		if(isset($_COOKIE["pass"])) {
			$pass = $_COOKIE["pass"];
		}
	?>
	<head>
		<title>Sign in with your account and password</title>
	</head>
	<body>
		<form method="post" action="login.php">

			<div class="container">
				<label for="uname"><b>Username</b></label>
				<input type="text" value="<?php echo $user; ?>" placeholder="Enter Username" name="uname" required>

				<label for="psw"><b>Password</b></label>
				<input type="password" value="<?php echo $pass; ?>" placeholder="Enter Password" name="psw" required>

				<button type="submit">Login</button>
			</div>

			<div class="container" style="background-color:#f1f1f1">
				<span class="psw">Forgot <a href="recovery.php">password?</a></span>
			</div> 
		</form>
	</body>
</html> 
