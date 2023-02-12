<?php

session_start();

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if($data->connect == 1)
{

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


	$cercaPartida = "SELECT * FROM partides WHERE Començada = 0";
	$search = $conn->query($cercaPartida);
	$count = $search->num_rows;

	if($count > 0) // hi ha partides començades
	{
		$results= $search->fetch_all(MYSQLI_ASSOC);

		$sqlPing = "select lat from latencies where Jugador = '" . $_SESSION['email'] . "'";
		$searchLat = $conn->query($sqlPing);
		$countLat = $searchLat->num_rows;
		if($countLat > 0) // si el jugador ha fet el test de latencia
		{
			$resultLat = $searchLat->fetch_object();
			$partidaAct = null;
			foreach($results as $result)
			{
				if($resultLat->lat >= $result['Ping'] - 50 && $resultLat->lat <= $result['Ping'] + 50)
				{
					$partidaAct = $result;
					break;
				}
			}

			if($partidaAct != null) // hem trobat una partida que te una latencia similar a la nostre
			{
				$sql = "update partides set Jugador2 = '" . $_SESSION['email'] . "', Començada = 1  where idPartida = " . $partidaAct['idPartida'];
				if ($conn->query($sql))
				{
					$_SESSION['idPartida'] = $partidaAct['idPartida'];
					$conn->close();
					echo "0";
				}
				else
				{
					$conn->close();
					echo "-1"; // error
				}
			}
			else // no hi ha cap partida amb una latencia similar, creem una de nova
			{
				$sql = "INSERT INTO partides (Jugador1, Ping) VALUES ('" . $_SESSION['email'] . "', " . $resultLat->lat . ")";
				if ($conn->query($sql))
				{
					$cercaPartida2 = "SELECT idPartida FROM partides WHERE idPartida = (SELECT MAX(idPartida) FROM partides)";
					$search2 = $conn->query($cercaPartida2);
					$result2 = $search2->fetch_object();

					$_SESSION['idPartida'] = $result2->idPartida;

					$conn->close();
					echo "0"; // true
				}
				else
				{
					$conn->close();
					echo "-1"; // error
				}
			}
		}
		else
		{
			$conn->close();
			echo "-1"; // error
		}
	}
	else // no hi ha cap partida començada
	{
		$sqlPing = "select lat from latencies where Jugador = '" . $_SESSION['email'] . "'";
		$searchLat = $conn->query($sqlPing);
		$countLat = $searchLat->num_rows;
		if($countLat > 0) // si el jugador ha fet el test de latencia
		{
			$resultLat = $searchLat->fetch_object();
			$sql = "INSERT INTO partides (Jugador1, Ping) VALUES ('" . $_SESSION['email'] . "', " . $resultLat->lat . ")";
			if ($conn->query($sql))
			{
				$cercaPartida2 = "SELECT idPartida FROM partides WHERE idPartida = (SELECT MAX(idPartida) FROM partides)";
				$search2 = $conn->query($cercaPartida2);
				$result2 = $search2->fetch_object();

				$_SESSION['idPartida'] = $result2->idPartida;

				$conn->close();
				echo "0"; // true
			}
			else
			{
				$conn->close();
				echo "-1"; // error
			}
		}
		else
		{
			$conn->close();
			echo "-1"; // error
		}
	}
}
else
{
	header("Location: ../main.php");
	echo "-1";
}

?>

