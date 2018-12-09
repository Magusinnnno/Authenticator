<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$emailErr = "";
$email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["email"])) {
    $emailErr = "Email necessari";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "E-mail invàlid. Error de format"; 
    }
  }
    
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Recuperar contrasenya oblidada</h2>
<p><span class="error">* camp necessari</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  
  E-mail: <input type="text" name="email">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
    /*conectar-se a la base de dades i mirar si existeix un usuari amb aquest email
    ...
    si existeix llavors agafar el "recuperador" i guardar-lo en una variable
    $recuperador = ...
    */
    $recuperador="";
    if ($recuperador=="") {
      // the message
      $msg = "Fes click a aquest enllaç per accedir a una pàgina per restablir la teva contrasenya: http://algunFitxer.php?$recuperador";
      // use wordwrap() if lines are longer than 70 characters
      $msg = wordwrap($msg,70);
      
      // send email
      if (mail("$email","Recuperar contrasenya",$msg)) {
        echo "E-mail correcte, t'hem enviat un correu amb lo necessari per restablir la teva contrasenya. \n";
      }
      
      
    } else {
      echo "No existeix cap usuari a la base de dades registrat amb aquest E-mail.";
    }
}
?>

</body>
</html>