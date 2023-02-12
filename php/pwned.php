<?php

require_once('../vendor/autoload.php');

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

$pp = new PwnedPasswords\PwnedPasswords;


if ($pp->isPwned($data->pass))
{
    echo "-1";
}
else
{
    echo "0";
}


?>
