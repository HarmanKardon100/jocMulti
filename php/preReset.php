<?php

session_start();

header("Content-Type: application/json");

$servername = "localhost";
$username = "user";
$password ="#HKS";
$dbname = "Multijugador";

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
	header("Location: ../main.php");
}


$sql = "update partides set EleccioJ1 = 0, EleccioJ2 = 0, RandGot = 0, RandCol = 0 where idPartida = " . $_SESSION['idPartida'];
if($conn->query($sql))
{
	$conn->close();
	echo "0";
}
else
{
	$conn->close();
	echo "-1";
}
?>
