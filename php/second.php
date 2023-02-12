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

	$sql = "update latencies set dat2 = CURRENT_TIMESTAMP(6) where Jugador = '" . $_SESSION['email'] . "'";
	if($conn->query($sql))
	{
		$sql2 = "update latencies set lat = ((dat2-dat1)/2)*1000 where Jugador = '" . $_SESSION['email'] . "'";
		if($conn->query($sql2))
		{
			$sql3 = "select lat from latencies where Jugador = '" . $_SESSION['email'] . "'";
			if($search = $conn->query($sql3))
			{
				$result = $search->fetch_object();
				$conn->close();

				$myObj = new stdClass();
				$myObj->res = "0";
				$myObj->ping = $result->lat;

				echo json_encode($myObj);
			}
			else
			{
				$conn->close();

				$myObj = new stdClass();
				$myObj->res = "-1";

				echo json_encode($myObj);
			}
		}
		else
		{
			$conn->close();

			$myObj = new stdClass();
			$myObj->res = "-1";
			echo json_encode($myObj);
		}
	}
	else
	{
		$conn->close();

		$myObj = new stdClass();
		$myObj->res = "-1";

		echo json_encode($myObj);

	}
}
else
{
	header("Location: ../index.html");
}


?>
