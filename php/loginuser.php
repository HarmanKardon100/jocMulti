<?php
session_start();
$email = $_POST['Email'];
$psw = $_POST['Contrasenya'];

//comprovacions
if($email == "" || $psw == "") {
  header("Location: ../index.html");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 255) {
  echo 'Something did not work. You will be redirected in 5 seconds';
  header( "refresh:5;url= ../entrar.html");
}
if(strlen($psw) < 8 && strlen($psw) > 64) {
  echo 'Something did not work. You will be redirected in 5 seconds';
  header( "refresh:5;url= ../entrar.html");
}

$servername = "localhost";
$username = "user";
$password ="#HKS";
$dbname = "Multijugador";

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  header("Location: ../index.html");
}

$cercaemail = "SELECT Sal FROM usuaris WHERE Correu = '" . $email . "'";
$numemail = $conn->query($cercaemail);
$count = $numemail->num_rows;

if($count > 0) {
	$result = $numemail->fetch_object();
	// hash pswd
	$str_result ='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$sal = $result->Sal;
	$hash = hash_pbkdf2('sha1', $psw, $sal, 10000, 64, false);
	$sqlCommand = "SELECT * FROM usuaris WHERE Correu = '". $email ."' AND Contrasenya = '". $hash ."'";
	$numrows = $conn->query($sqlCommand);
	$exist = $numrows->num_rows;
	if($exist > 0)
	{
		$conn->close();
		$_SESSION['email'] = $email;
		header( "refresh:0;url= ../main.php");
	}
	else
	{
		$conn->close();
		echo 'Password incorrect. You will be redirected in 5 seconds';
		header( "refresh:5;url= ../entrar.html");
	}
}
else {
	$conn->close();
	echo 'This email is not registered. You will be redirected in 5 seconds';
	header( "refresh:5;url= ../entrar.html");
}
?>
