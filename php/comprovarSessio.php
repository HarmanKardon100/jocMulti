<?php
	session_start();
        if (isset($_SESSION['email']))
        {
		header( "refresh:0;url=../main.php");
        }
	else
	{
		header( "refresh:0;url=../entrar.html");
	}
?>
