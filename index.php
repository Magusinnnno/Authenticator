<!DOCTYPE html>
<html>
	<head>
		<title>Sign in with your account and password</title>
	</head>
	<body>
		<form method="post" action="login.php">

			<div class="container">
				<label for="uname"><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="user" required>

				<label for="psw"><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="pass" required>

				<button type="submit">Login</button>
			</div>

			<div class="container" style="background-color:#f1f1f1">
				<span class="psw">Forgot <a href="#">password?</a></span>
			</div> 
		</form>
	</body>
</html> 
