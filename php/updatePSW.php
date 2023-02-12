<?php

if($_POST['Email'] && $_POST['contra1'])
{

	if(strlen($_POST['contra1']) < 8)
	{
		header("Location: ../index.html");
	}


	$servername = "localhost";
	$username = "user";
	$password = "#HKS";
	$dbname = "Multijugador";
	// hash pswd
	$str_result ='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$sal = substr(str_shuffle($str_result), 0, 16);
	$hash = hash_pbkdf2('sha1', $_POST['contra1'], $sal, 10000, 64, false);
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	  header("Location: ../index.html");
	}
	$updatepswd = "UPDATE usuaris SET Contrasenya = '". $hash ."', Sal = '" . $sal . "', CodiCont = NULL WHERE Correu = '". $_POST['Email'] ."'";
	$update = $conn->query($updatepswd);
	$conn->close();
	echo 'Password updated. You will be redirected in 5 seconds';
	header( "refresh:5;url= ../entrar.html");
}
else {
	echo "ERROR";
	header( "refresh:;url= ../index.html");
}
?>

