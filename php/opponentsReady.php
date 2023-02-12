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

$cercauser = "SELECT Jugador1, Jugador2 FROM partides WHERE idPartida = " . $_SESSION['idPartida'];
if($search = $conn->query($cercauser))
{
	$result = $search->fetch_object();

	if($result->Jugador1 !== null && $result->Jugador2 !== null)
	{
		if($result->Jugador1 == $_SESSION['email'])
		{
			$conn->close();
			$_SESSION['email2'] = $result->Jugador2;
			echo "0";
		}
		else if($result->Jugador2 == $_SESSION['email'])
		{
			$conn->close();
			$_SESSION['email2'] = $result->Jugador1;
			echo "0";
		}
		else
		{
			$conn->close();
			echo "-3";
		}
	}
	else
	{
		$conn->close();
		echo "-1";
	}
}
else
{
	var_dump($_SESSION['idPartida']);
	$conn->close();
	echo "-2";
}
?>
