<?php

$nom = $_POST['Nom'];
$cognom = $_POST['Cognom'];
$email = $_POST['Email'];
$psw = $_POST['Contrasenya'];


//comprovacions
if($nom == "" || $cognom == "" || $email == "" || $psw == "")
{
  header("Location: ../register.html");
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header("Location: ../register.html");
}
if(strlen($psw) < 8) {
  header("Location: ../register.html");
}


$servername = "localhost";
$username = "user";
$password ="#HKS";
$dbname = "Multijugador";

// hash pswd
$str_result ='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
$sal = substr(str_shuffle($str_result), 0, 16);
$hash = hash_pbkdf2('sha1', $psw, $sal, 10000, 64, false);

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  header("Location: http://multijugador-udg.westeurope.cloudapp.azure.com/register.html");
}

$cercaemail = "SELECT * FROM usuaris WHERE Correu = '" . $email . "'";
$numemail = $conn->query($cercaemail);
$count = $numemail->num_rows;

if($count<=0) {

  $sql = "INSERT INTO usuaris (Nom, Cognoms, Correu, Contrasenya, sal)
	VALUES ('" . $nom . "','" . $cognom . "','" . $email . "','" . $hash . "','" . $sal . "')";
  if ($conn->query($sql) === TRUE)
  {
    echo 'Registered Successfully. You will be redirected in 5 seconds';
    $conn->close();
    header( "refresh:5;url= ../entrar.html");
  }
  else
  {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
    header("Location: ../register.html");
  }
}
else {
  $conn->close();
  echo 'This email is already being used. You will be redirected in 5 seconds';
  header( "refresh:5;url= ../register.html");
}
?>
