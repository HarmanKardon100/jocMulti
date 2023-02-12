<!DOCTYPE html> <html>
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="/css/style.css">
  </head>
  <body>
  <div id="content" >
	<h2> <?php
		session_start();
                if($_SESSION['email'])
                {
			echo $_SESSION['email'];
                }
                else
                {
			header("Location: ../index.html");
                }
		?>  </h2>
	<button onclick="window.location.href='/pre-game.html'">Jugar</button>
	<button onclick="window.location.href='/php/cookie_deleter.php'">Tanca Sessio</button>
  </div>
  </body>
</html>
