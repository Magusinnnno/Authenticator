<?php
	echo '<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="image/png; charset=UTF-8"> 
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="description" content="Draw">
			<title>Shot the enemy game</title>
		</head>
		<body>';
			function getUserIP(){
				$clientIp  = @$_SERVER['HTTP_CLIENT_IP'];
				$forwardIp = @$_SERVER['HTTP_X_FORWARDED_FOR'];
				$remoteIp  = $_SERVER['REMOTE_ADDR'];

				if(filter_var($clientIp, FILTER_VALIDATE_IP))
				{
					$ip = $clientIp;
				}
				elseif(filter_var($forwardIp, FILTER_VALIDATE_IP))
				{
					$ip = $forwardIp;
				}
				else
				{
					$ip = $remoteIp;
				}

				return $ip;
			}

			//$user_ip = getUserIP();
			//echo $user_ip;
			
			$width=1280;
			$height=720;
			$blue = "https://imgur.com/21fdKbn.jpg";
			$green = "https://imgur.com/mzMoGZx.jpg";
			$red = "https://imgur.com/DEf7Y3o.jpg";
			$positionsX = array();
			$positionsY = array();
			
			try{
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
					
					echo '<div style="position: absolute; 
							top: '.$positionY.'px;
							bottom: '.($height - $positionY).'px; 
							left: '.$positionX.'px;
							right: '.($width - $positionX).'px; ">

							<a href="?clicked='.$i.'"><img src="'.$blue.'"></a>
							</div>';
				}
			}
			catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
			
		echo '</body>
	</html>';
?>