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

$sql = "SELECT EleccioJ1,  EleccioJ2 FROM partides WHERE idPartida = " . $_SESSION['idPartida'];
if($search = $conn->query($sql))
{
	$result = $search->fetch_object();

	if($result->EleccioJ1 != 0 || $result->EleccioJ2 != 0)
	{
		$conn->close();
		echo "0";
	}
	else
	{
		$conn->close();
		echo "-1";
	}
}
else
{
	$conn->close();
	echo "-2";
}

?>
