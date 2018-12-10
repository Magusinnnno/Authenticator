<?php

require_once "config.php";
// define variables and set to empty values
$emailErr = "";
$email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["email"])) {
    $emailErr = "email is necessary";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "\n invalid email. Format error"; 
    }
  }
  if(empty($emailErr)){
    // Prepare a select statement
    $sql = "SELECT email, password FROM users WHERE email = ?";
        
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        
        // Set parameters
        $param_email = $email;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);
            
            // Check if email exists, if yes then send mail
            if(mysqli_stmt_num_rows($stmt) == 1){    

                  $password=randomPassword();

                  
                  // Prepare an update statement
                  $sql = "UPDATE users SET password = ? WHERE email = ?";
                  
                  if($stmt = mysqli_prepare($link, $sql)){
                      // Bind variables to the prepared statement as parameters
                      mysqli_stmt_bind_param($stmt, "si", $param_password, $param_email);
                      
                      // Set parameters
                      $param_password = password_hash($password, PASSWORD_DEFAULT);
                      $param_id = $email;
                      
                      // Attempt to execute the prepared statement
                      if(mysqli_stmt_execute($stmt)){
                          
                      } else{
                          echo "Oops! Something went wrong. Please try again later.";
                      }
                  }

                  if ($password!=="") {
                    // the message
                  
                    $msg = "Your new password is $password. Remember you can change this password when you login";
                    // use wordwrap() if lines are longer than 70 characters
                    $msg = wordwrap($msg,70);
                    
                    // send email
                    if (mail("$email","New password",$msg)) {
                      echo "<div class='wrapper'><h4>Correct email, we sent you an email with your new password. \n </h4> <p>Now you can login with the new password </p><p> <a href='login.php'>Login here</a>.</p></div>";
                      
                    }
                                      
                  } 

            } else{
                // Display an error message if email doesn't exist
                echo "<div class='wrapper'><h4> No account found with that email. \n </h4></div>";
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
  }



// Close connection
mysqli_close($link);
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function randomPassword() {
  $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
  $pass = array(); //remember to declare $pass as an array
  $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
  for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
  }
  return implode($pass); //turn the array into a string
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recovery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>  
<div class="wrapper">

<h2>Recover forgotten password</h2>
<p><span class="error">* necessary field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  
  email: <input type="text" name="email">
  <span class="error">* </span>
  <p></p>
  <?php echo $emailErr;?>
  <br><br>
  
  <input type="submit" name="submit" value="Submit">  
</form>
</div>

</body>
</html>