<?php
echo '<!DOCTYPE html>
<html lang="ca">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Register a new account</title>
	</head>
	<body>
		<h1>Register a new account</h1>
		<form action="./check.php" method="post" target="_self">
			First name:<br>
			<input type="text" name="firstname"><br>
			Last name:<br>
			<input type="text" name="lastname"><br>
			Email:<br>
			<input type="text" name="email"><br>
			Nickname: <br>
			<input type="text" name="nick"><br>
			Password: <br>
			<input type="password" name="password"><br>
			<input type="submit" value="Register" />
		</form>
		<hr>
		<footer>
			<p>All rights reserved &copy; 2018 by Adrià Gómez, Pau Olivés and Sergio Rustarazo.</p>
			<hr>
		</footer>
	</body>
</html>'
?>
