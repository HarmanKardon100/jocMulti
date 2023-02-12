<?php

session_start();

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

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

$sql = "SELECT Jugador1, Jugador2, EleccioJ1, EleccioJ2 FROM partides WHERE idPartida = " . $_SESSION['idPartida'];
if($search = $conn->query($sql))
{
	$result = $search->fetch_object();

	if($_SESSION['email'] == $result->Jugador1) // soc jugador 1
	{
		$sql2 = "update partides set EleccioJ1 = " . $data->click . " where idPartida = " . $_SESSION['idPartida'];
		if($conn->query($sql2))
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
	else if($_SESSION['email'] == $result->Jugador2) // soc jugador 2
	{
		$sql2 = "update partides set EleccioJ2 = " . $data->click . " where idPartida = " . $_SESSION['idPartida'];
		if($conn->query($sql2))
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
	else // error
	{
		$conn->close();
		echo "-2";
	}
}

?>
