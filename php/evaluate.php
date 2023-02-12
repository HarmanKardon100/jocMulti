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


$sql = "SELECT * FROM partides WHERE idPartida = " . $_SESSION['idPartida'];
if($search = $conn->query($sql))
{
	$result = $search->fetch_object();

	if($_SESSION['email']==$result->Jugador1) // soc jugador 1
	{
		if($result->EleccioJ1 != 0 && $result->EleccioJ2 != 0) // col·lisió
		{
			if($result->RandCol == 1) // fem que ha marcat primer jugador 1
			{
				if($result->EleccioJ1 == $result->RandGot) // jugador 1 ha guanyat
				{
					$sql2 = "update partides set PuntsJ1 = PuntsJ1 + 10 where idPartida = " . $_SESSION['idPartida'];
					if($conn->query($sql2))
					{
						$myObj = new stdClass();
						$myObj->res = "1";
						$myObj->cup = $result->EleccioJ1;

						echo json_encode($myObj);
					}
					else
					{
						$myObj = new stdClass();
						$myObj->res = "-1";
						echo json_encode($myObj);
					}
				}
				else // jugador 1 ha perdut
				{
					$myObj = new stdClass();
					$myObj->res = "3";
					$myObj->cup = $result->EleccioJ1;
					echo json_encode($myObj);
				}
			}
			else if ($result->RandCol == 2) // fem que ha marcat primer jugador 2
			{
				if($result->EleccioJ2 == $result->RandGot) // jugador 2 ha guanyat
				{
					$myObj = new stdClass();
					$myObj->res = "2";
					$myObj->cup = $result->EleccioJ2;
					echo json_encode($myObj);
				}
				else // jugador 2 ha perdut
				{
					$myObj = new stdClass();
					$myObj->res = "4";
					$myObj->cup = $result->EleccioJ2;
					echo json_encode($myObj);
				}
			}
		}
		else if($result->EleccioJ1 != 0) // jugador 1 ha marcat got
		{
			if($result->EleccioJ1 == $result->RandGot) // jugador 1 ha guanyat
			{
				$sql2 = "update partides set PuntsJ1 = PuntsJ1 + 10 where idPartida = " . $_SESSION['idPartida'];
				if($conn->query($sql2))
				{
					$myObj = new stdClass();
					$myObj->res = "1";
					$myObj->cup = $result->EleccioJ1;
					echo json_encode($myObj);
				}
				else
				{
					$myObj = new stdClass();
					$myObj->res = "-1";
					echo json_encode($myObj);
				}

			}
			else // jugador 1 ha perdut
			{
				$myObj = new stdClass();
				$myObj->res = "3";
				$myObj->cup = $result->EleccioJ1;
				echo json_encode($myObj);
			}
		}
		else if($result->EleccioJ2 != 0) // jugador 2 ha marcat got
		{
			if($result->EleccioJ2 == $result->RandGot) // jugador 2 ha guanyat
			{
				$myObj = new stdClass();
				$myObj->res = "2";
				$myObj->cup = $result->EleccioJ2;
				echo json_encode($myObj);
			}
			else // jugador 2 ha perdut
			{
				$myObj = new stdClass();
				$myObj->res = "4";
				$myObj->cup = $result->EleccioJ2;
				echo json_encode($myObj);
			}
		}
		else // error, s'ha cridat evaluar quan no tocava
		{
			$conn->close();

			$myObj = new stdClass();
			$myObj->res = "-2";
			echo json_encode($myObj);
		}

	}
	else if($_SESSION['email']==$result->Jugador2) // soc jugador 2
	{
		if($result->EleccioJ1 != 0 && $result->EleccioJ2 != 0) // col·lisió
		{
			if($result->RandCol == 1) // fem que ha marcat primer jugador 1
			{
				if($result->EleccioJ1 == $result->RandGot) // jugador 1 ha guanyat
				{
					$myObj = new stdClass();
					$myObj->res = "2";
					$myObj->cup = $result->EleccioJ1;
					echo json_encode($myObj);
				}
				else // jugador 1 ha perdut
				{
					$myObj = new stdClass();
					$myObj->res = "4";
					$myObj->cup = $result->EleccioJ1;
					echo json_encode($myObj);
				}
			}
			else if ($result->RandCol == 2) // fem que ha marcat primer jugador 2
			{
				if($result->EleccioJ2 == $result->RandGot) // jugador 2 ha guanyat
				{
					$sql2 = "update partides set PuntsJ2 = PuntsJ2 + 10 where idPartida = " . $_SESSION['idPartida'];
					if($conn->query($sql2))
					{
						$myObj = new stdClass();
						$myObj->res = "1";
						$myObj->cup = $result->EleccioJ2;
						echo json_encode($myObj);
					}
					else
					{
						$myObj = new stdClass();
						$myObj->res = "-1";
						echo json_encode($myObj);
					}

				}
				else // jugador 2 ha perdut
				{
					$myObj = new stdClass();
					$myObj->res = "3";
					$myObj->cup = $result->EleccioJ2;
					echo json_encode($myObj);
				}
			}
		}
		else if($result->EleccioJ1 != 0) // jugador 1 ha marcat got
		{
			if($result->EleccioJ1 == $result->RandGot) // jugador 1 ha guanyat
			{
				$myObj = new stdClass();
				$myObj->res = "2";
				$myObj->cup = $result->EleccioJ1;
				echo json_encode($myObj);
			}
			else // jugador 1 ha perdut
			{
				$myObj = new stdClass();
				$myObj->res = "4";
				$myObj->cup = $result->EleccioJ1;
				echo json_encode($myObj);
			}
		}
		else if($result->EleccioJ2 != 0) // jugar 2 ha marcat got
		{
			if($result->EleccioJ2 == $result->RandGot) // jugador 2 ha guanyat
			{
				$sql2 = "update partides set PuntsJ2 = PuntsJ2 + 10 where idPartida = " . $_SESSION['idPartida'];
				if($conn->query($sql2))
				{
					$myObj = new stdClass();
					$myObj->res = "1";
					$myObj->cup = $result->EleccioJ2;
					echo json_encode($myObj);
				}
				else
				{
					$myObj = new stdClass();
					$myObj->res = "-1";
					echo json_encode($myObj);
				}

			}
			else // jugador 2 ha perdut
			{
				$myObj = new stdClass();
				$myObj->res = "3";
				$myObj->cup = $result->EleccioJ2;
				echo json_encode($myObj);
			}
		}
		else // error, s'ha cridat evaluar quan no tocava
		{
			$conn->close();

			$myObj = new stdClass();
			$myObj->res = "-2";
			echo json_encode($myObj);
		}
	}
	else // error, jugadors no coincideixen
	{
		$conn->close();

		$myObj = new stdClass();
		$myObj->res = "-4";
		echo json_encode($myObj);

	}

}



?>
