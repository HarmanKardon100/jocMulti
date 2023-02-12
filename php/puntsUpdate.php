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
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
	header("Location: ../main.php");
}
$sql = "SELECT Jugador1, Jugador2, PuntsJ1, PuntsJ2 FROM partides WHERE idPartida = " . $_SESSION['idPartida'];
if($search = $conn->query($sql))
{
	$result = $search->fetch_object();
	if($result->Jugador1 == $_SESSION['email'])
	{
		$conn->close();
		$myObj = new stdClass();
		$myObj->res = "0";
		$myObj->p1 = $result->PuntsJ1;
		$myObj->p2 = $result->PuntsJ2;
		echo json_encode($myObj);
	}
	else if($result->Jugador2 == $_SESSION['email'])
	{
		$conn->close();
		$myObj = new stdClass();
		$myObj->res = "0";
		$myObj->p1 = $result->PuntsJ2;
		$myObj->p2 = $result->PuntsJ1;
		echo json_encode($myObj);
	}
	else
	{
		$conn->close();
		$myObj = new stdClass();
		$myObj->res = "-2";
		echo json_encode($myObj);
	}
}
else {
	$conn->close();
	$myObj = new stdClass();
	$myObj->res = "-1";
	echo json_encode($myObj);
}
?>
