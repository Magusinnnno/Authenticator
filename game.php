
<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="description" content="Draw">
			<title>Shot the enemy game</title>
		
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
			<style type="text/css">
				body{ font: 14px sans-serif; }
				.wrapper{ width: 350px; padding: 20px; }
			</style>
		</head>
		
		<body>
		<?php
			try{
				// Initialize the session
				session_start();
				
				// Check if the user is logged in, if not then redirect him to login page
				if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
					header("location: login.php");
					exit;
				}

				//connectar-se a bdd, si hi ha una sessió oberta agafar les dades, sino crear-la
				// Include config file
				require_once "config.php";
				
				// Check inputs
				if (isset($_GET['clicked'])) {
					
					$sql = "INSERT IGNORE INTO game(id, username) VALUES (".trim($_GET['clicked']).", '".$_SESSION["username"]."')";
					
					if($stmt = mysqli_prepare($link, $sql)){
						if(mysqli_stmt_execute($stmt)){
							mysqli_stmt_store_result($stmt);
							
							if(mysqli_stmt_num_rows($stmt) == 0){
								//echo "Something went wrong!\n";
							}
						}
					}
					
					// Close statement
					mysqli_stmt_close($stmt);
					
					$sql = "SELECT MAX(latency) FROM users;";
					
					if($stmt = mysqli_prepare($link, $sql)){
						if(mysqli_stmt_execute($stmt)){
							mysqli_stmt_store_result($stmt);
							
							if(mysqli_stmt_num_rows($stmt) == 1){
								mysqli_stmt_bind_result($stmt, $latency);
								sleep(ceil($latency));
							}
						}
					}
					
					// Close statement
					mysqli_stmt_close($stmt);
				}
				
				// Load Game State
				// Prepare a select statement
				$sql = "SELECT id FROM circles";
				$game=false;
			
				if($stmt = mysqli_prepare($link, $sql)){
					
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						// Store result
						mysqli_stmt_store_result($stmt);
						
						// Check if username exists, if yes then verify password
						if(mysqli_stmt_num_rows($stmt) == 0){                    
							echo 'no existeix cap sessió de joc. ';
							$game=false;
							//crear 5 cercles i guardar-los a bdd
						}
						else{
							//echo 'existeix sessió de joc.';
							$game=true;
							//carregar cercles 
						}
					} else{
						echo "Oops! Something went wrong. Please try again later.";
					}
				}
				
				// Close statement
				mysqli_stmt_close($stmt);
			
				
				$width=1280;
				$height=720;
				$blue = "https://imgur.com/21fdKbn.jpg";
				$green = "https://imgur.com/mzMoGZx.jpg";
				$red = "https://imgur.com/DEf7Y3o.jpg";
				$positionsX = array();
				$positionsY = array();

				if ($game==false){
					for ($i = 0; $i < 5; $i++) {
						$positionX = rand(50, $width - 50);
						$trobat = true;
						$max = count($positionsX);
						while ($trobat) {
							$x = 0;
							$trobat = false;
							while ($x < $max && !$trobat) {
								$trobat = ($positionsX[$x] == $positionX || ($positionsX[$x] + 50 > $positionX - 50 && $positionsX[$x] < $positionX)) || ($positionsX[$x] - 50 < $positionX + 50 && $positionsX[$x] > $positionX);
								$x++;
							}
							if ($trobat) {
								$positionX = rand(50, $width - 50);
							}
						}
						$positionsX[] = $positionX;
						$positionY = rand(50, $height - 50);
						$trobat = true;
						while ($trobat) {
							$y = 0;
							$trobat = false;
							while ($y < $max && !$trobat) {
								$trobat = ($positionsY[$y] == $positionY || ($positionsY[$y] + 50 > $positionY - 50 && $positionsY[$y] < $positionY)) || ($positionsY[$y] - 50 < $positionY + 50 && $positionsY[$y] > $positionY);
								$y++;
							}
							if ($trobat) {
								$positionY = rand(50, $height - 50);
							}
						}
						$positionsY[] = $positionY;
						// Prepare a insert statement
						$sql = "INSERT INTO circles(id, posX, posY) VALUES (?,?,?)";

						if($stmt = mysqli_prepare($link, $sql)){
							// Bind variables to the prepared statement as parameters
							mysqli_stmt_bind_param($stmt, "sss", $param_id, $param_posX, $param_posY);
							
							// Set parameters
							$param_id = $i;
							
							$param_posX = $positionX;
							$param_posY = $positionY;
							// Attempt to execute the prepared statement
							if(mysqli_stmt_execute($stmt)){
								echo " cercle ". $i . " creat,";
								
							} else{
								echo "Something went wrong. Please try again later.";
							}
						}
						// Close statement
						mysqli_stmt_close($stmt);
					}


				} else{
					for ($i = 0; $i < 5; $i++) {
						$sql = "SELECT posX, posY FROM `circles` WHERE id = ?";
						if($stmt = mysqli_prepare($link, $sql)){
							// Bind variables to the prepared statement as parameters
							mysqli_stmt_bind_param($stmt, "s", $param_id);
							// Set parameters
							$param_id = $i;
							 // Attempt to execute the prepared statement
							if(mysqli_stmt_execute($stmt)){
								// Store result
								mysqli_stmt_store_result($stmt);
								
								// Check if id exists, if yes then save position
								if(mysqli_stmt_num_rows($stmt) == 1){                    
									// Bind result variables
									mysqli_stmt_bind_result($stmt, $positionX, $positionY);
									if(mysqli_stmt_fetch($stmt)){
										
										// Close statement
										mysqli_stmt_close($stmt);
										
										$sql = "SELECT t1.username FROM game AS t1 JOIN users AS t2 ON t1.username = t2.username WHERE t1.id = ".$i." AND t1.clicked - SEC_TO_TIME(t2.latency) = ( SELECT MIN(t1.clicked - SEC_TO_TIME(t2.latency)) FROM game AS t1 JOIN users AS t2 ON t1.username = t2.username WHERE t1.id = ".$i." );";
										
										if($stmt = mysqli_prepare($link, $sql)){
											if(mysqli_stmt_execute($stmt)){
												// Store result
												mysqli_stmt_store_result($stmt);
												if(mysqli_stmt_num_rows($stmt) == 0){
													echo '<div style="position: absolute; 
														top: '.$positionY.'px;
														bottom: '.($height - $positionY).'px; 
														left: '.$positionX.'px;
														right: '.($width - $positionX).'px; ">
														<a href="?clicked='.$i.'"><img src="'.$blue.'"></a>
														</div>';
												}
												else {
													mysqli_stmt_bind_result($stmt, $winner);
													if(mysqli_stmt_fetch($stmt)){
														if ($winner == $_SESSION["username"]) {
															echo '<div style="position: absolute; 
															top: '.$positionY.'px;
															bottom: '.($height - $positionY).'px; 
															left: '.$positionX.'px;
															right: '.($width - $positionX).'px; ">
															<img src="'.$green.'">
															</div>';
														}
														else {
															echo '<div style="position: absolute; 
															top: '.$positionY.'px;
															bottom: '.($height - $positionY).'px; 
															left: '.$positionX.'px;
															right: '.($width - $positionX).'px; ">
															<img src="'.$red.'">
															</div>';
														}
													}
												}
											}
										}
										
										$positionsX[]=$positionX;
										$positionsY[]=$positionY;

									}
								}
							}
							
						}
					}
				}

				// Close connection
				mysqli_close($link);
            }            
			catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		?>
		<div class="wrapper">
			<div class="form-group">
			<a href="logout.php" class="btn btn-default">Exit</a>
			</div>
		</div>
	</body>
</html>