<?php
	session_start();
	$_SESSION = [];
	if (ini_get("session.use_cookies"))
	{
    		setcookie(session_name(), "", time() - 3600);
	}
	session_destroy();
	header( "refresh:0;url=../index.html");
	//header("Location: http://multijugador-udg.westeurope.cloudapp.azure.com/index.html"); ?>
