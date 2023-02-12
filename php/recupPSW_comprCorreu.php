<?php

if($_GET['Email'] && $_GET['CodiCont'])
{
	$servername = "localhost";
	$username = "user";
	$password ="#HKS";
	$dbname = "Multijugador";

	$email = $_GET['Email'];

	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		header("Location: ../index.html");
	}
	$cercaemail = "SELECT Correu, CodiCont FROM usuaris WHERE Correu = '" . $email . "' AND CodiCont ='" . $_GET['CodiCont'] . "'";
	$numemail = $conn->query($cercaemail);
	$count = $numemail->num_rows;

	if($count > 0) // si es correcte
	{ ?>

		<!DOCTYPE html> <html>
			<head>
    				<meta charset="utf-8">
        			<link rel="stylesheet" href="../css/style.css">
  			</head>
  			<body>
 				 <div id="content" >
          				<form action="/php/updatePSW.php" method="POST">
						<input type="hidden" name="Email" value="<?php echo $email;?>">
                				<label for="pswd">Contrasneya:</label><br>
                				<input type="password" id="contra1" class="" name="contra1">
                					<div id="message" disabled>
                        					<p id="length" class="invalid">Minimum <b>8 characters</b></p>
                					</div>
                				<br>
                				<label for="contra2">Repeteix contrasneya:</label><br>
                				<input type="password" id="contra2" class="" name="contra2">
                					<div id="message2" disabled>
                        					<p id="equal" class="invalid">Passwords must be the same</p>
                					</div>
                				<br>
                				<br>
                				<input id="envia" type="submit" value="Submit" disabled>
          				</form>
  				</div>
  			</body>
			<script src="../js/scripPsw.js"></script>
		</html>

	<?php
	}
	else {
    		$conn->close();
    		echo 'This email is not registered. You will be redirected in 5 seconds';
    		header( "refresh:5;url= ../index.html");
	}
}
else {
    echo 'This email is not registered. You will be redirected in 5 seconds';
    header( "refresh:5;url= ../index.html");
}
?>

