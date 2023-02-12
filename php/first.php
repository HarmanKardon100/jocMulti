<?php

session_start();

if($_SESSION['email'] || $_SESSION['email'] != "")
{
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


	$sql = "SELECT * FROM latencies WHERE Jugador = '" . $_SESSION['email'] . "'";
	if($search = $conn->query($sql))
	{
		$count = $search->num_rows;
		if($count > 0) // si el jugador ja esta a la taula anteriorment
		{
			$sql2 = "update latencies set dat1 = CURRENT_TIMESTAMP(6) where Jugador = '" . $_SESSION['email'] . "'";
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
		else // primera vegada que el jugador juga
		{
			$sql2 = "insert into latencies (Jugador) VALUES ('" . $_SESSION['email'] . "')";
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
	}
	else
	{
		$conn->close();
		echo "-1";
	}
}
else
{
	header("Location: ../index.html");
}


?>
