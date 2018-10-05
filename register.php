<!DOCTYPE html>
<html>
	<head>
		<title>Register a new account</title>
	</head>
	<body>
		<?php>
		try {
		    $conn = new PDO("sqlsrv:server = tcp:gddv.database.windows.net,1433; Database = sm", "sm", "{your_password_here}");
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) {
		    print("Error connecting to SQL Server.");
		    die(print_r($e));
		}

		// SQL Server Extension Sample Code:
		$connectionInfo = array("UID" => "sm@gddv", "pwd" => "{your_password_here}", "Database" => "sm", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
		$serverName = "tcp:gddv.database.windows.net,1433";
		$conn = sqlsrv_connect($serverName, $connectionInfo);
		?>
		<form>
			First name:<br>
			<input type="text" name="firstname"><br>
			Last name:<br>
			<input type="text" name="lastname"><br>
			Email:<br>
			<input type="text" name="email"><br>
		</form>
		<?php
	    		
		?>
	</body>
</html> 
