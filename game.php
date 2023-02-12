<!DOCTYPE html>
<html>
    <head>
        <title>Code Club Cups</title>
        <link rel="stylesheet" href="/css/style2.css">

        <style>
            * { box-sizing: border-box; position: relative; }
            html, body { height: 100%; }

            body
            {
                max-width: 600px;
                margin: 0 auto;
            }

        </style>
    </head>
    <body>

        <div class="triangle-red"></div>
		<h1><?php session_start(); echo $_SESSION['email'];?> SCORE:</h1> <h1 id="score_p1"> 0</h1>
		<br></br>
		<div class="triangle-blue"></div>
		<h1><?php session_start(); echo $_SESSION['email2'];?> SCORE:</h1> <h1 id="score_p2"> 0</h1>
		<br></br>
		<h2 id='result' align="center"></h2>
		<br></br>
		<br></br>
		<div class="Row">
			<div id='ball1' class='ball' style='left:70px' ></div>
			<div id='ball2' class='ball' style='left:230px'></div>
			<div id='ball3' class='ball' style='left:390px'></div>
		</div>

        <div id='c1' class="trapezoid cup" onclick="choiceOne('1')"></div>
        <div id='c2' class="trapezoid cup" onclick="choiceOne('2')"></div>
        <div id='c3' class="trapezoid cup" onclick="choiceOne('3')"></div>

		<div id ="log"></div>
		<div id ="log_rival"></div>
		<br></br>
		<br></br>
		<br></br>
		<br></br>
		<br></br>
		<br></br>
		<br></br>
		<br></br>


		<h2 id='frase' align="center"></h2>
		<br></br>
		<br></br>

		<button type="button" onclick="window.location.href='main.php'">Exit</button>
    </body>
	<script src="/js/gameLogic.js"></script>
</html>
