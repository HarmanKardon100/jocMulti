<?php

session_start();

header("Content-Type: application/json");

$servername = "localhost";
$username = "user";
$password ="#HSK";
$dbname = "Multijugador";

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
	header("Location: ../main.php");
}

$sql = "SELECT Jugador1, Jugador2 FROM partides WHERE idPartida = " . $_SESSION['idPartida'];
if($serch = $conn->query($sql))
{
	$result = $serch->fetch_object();

	if($result->Jugador1 == $_SESSION['email']) // soc jugador 1
	{

		$sql2 = "update partides set RandGot = " . rand(1,3) . ", RandCol = " . rand(1,2) . " where idPartida = " . $_SESSION['idPartida'];
		if($conn->query($sql2)) // random fet
		{
			$conn->close();
			echo "0";
		}
		else // random no fet
		{
			$conn->close();
			echo "-1";
		}
	}
	else if($result->Jugador2 == $_SESSION['email']) // soc jugador 2
	{
		$sql2 = "SELECT RandGot FROM partides WHERE idPartida = " . $_SESSION['idPartida'];
		if($serch2 = $conn->query($sql2))
		{
			$result2 = $serch2->fetch_object();
			if($result2->RandGot === 0) // random no fet
			{
				$conn->close();
				echo "-1";
			}
			else // random fet
			{
				$conn->close();
				echo "0";
			}
		}
		else // error
		{
			$conn->close();
			echo "-2";
		}

	}
	else // error
	{
		$conn->close();
		echo "-3";
	}

}
else // error
{
	$conn->close();
	echo "-4";
}



?>
