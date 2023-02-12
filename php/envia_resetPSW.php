<?php
require '/usr/share/php/libphp-phpmailer/class.phpmailer.php';
require '/usr/share/php/libphp-phpmailer/class.smtp.php';

$email = $_POST['Email'];

if($email == "") {
        header("Location: ../index.html");
}


$servername = "localhost";
$username = "user";
$password ="#HKS";
$dbname = "Multijugador";


$randNum = substr(str_shuffle("0123456789"), 0, 4);

//create connection

$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  header("Location: ../index.html");
}
$cercaemail = "SELECT Correu FROM usuaris WHERE Correu = '" . $email . "'";
$numemail = $conn->query($cercaemail);
$count = $numemail->num_rows;

if($count > 0) {

	$result = $numemail->fetch_object(); // $result->Correu

	$creaNum = "UPDATE usuaris SET CodiCont = '" . $randNum . "' where Correu = '" . $email . "'";

	if($conn->query($creaNum))
	{
		$link="http://multijugador-final.westeurope.cloudapp.azure.com/php/recupPSW_comprCorreu.php?Email=" . $result->Correu . "&CodiCont=" . $randNum . " Click To Reset password";
		$conn->close(); // tanquem DDBB

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;

		$mail->SMTPAuth = true;

		$mail->Username = 'multijugador2022@gmail.com';
		$mail->Password = 'basket1551';

		$mail->setFrom('no-reply@gmail.com');
		$mail->addAddress($email);
		$mail->Subject = 'Reset password';

		$mail->Body = 'Click On This Link to Reset Password '. $link.'';


		if(!$mail->send())
		{
		  echo 'Email is not sent.';
		  echo 'Email error: ' . $mail->ErrorInfo;
		}
		else
		{
		  echo 'Email has been sent.';
		}
	}
	else
	{
		echo "Error canviant la password";
		header( "refresh:5;url= ../index.html");
	}

}
else {
        $conn->close();
        echo 'This email is not registered. You will be redirected in 5 seconds';
        header( "refresh:5;url= ../index.html");
}
?>
