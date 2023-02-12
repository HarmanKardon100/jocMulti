var pos_gots = ["1", "2", "3"];
var missatges_per_entretenir = ["Luck has a way of evaporating when you lean on it...","Luck always seems like it belongs to someone else...", "Concentration attracts luck factor...", "Risk means 'shit happens' or 'good luck'...", "Nobody knows anything...", "You never know what worse luck your bad luck has saved you from...","Luck is believing you're lucky...", "It takes only a moment for the destiny to flip over...","Confidence is similar to luck. You can't hold it forever at your service!...","In life you have to be lucky that you are not unlucky..."];

var ha_clicat=true;

var valor_triat=0;
var valor_triat_rival=0;

var puntuacio_p1=0;
var puntuacio_p2=0;


ResetGame();


function ResetGame()
{
	valor_triat=0;
	valor_triat_rival=0;

	ha_clicat=true;
	BaixaGots();

	document.getElementById("result").innerHTML ="READY....";

	document.getElementById("log").innerHTML="<div id= 'log'>  </div>";	//reset de l'objecte "fletxa"
	document.getElementById("log_rival").innerHTML="<div id= 'log'>  </div>";
	document.getElementById("frase").innerHTML="<h2 id='frase' align='center'></h2>";

	document.getElementById("ball1").style.visibility="hidden";
	document.getElementById("ball2").style.visibility="hidden";
	document.getElementById("ball3").style.visibility="hidden";

	setTimeout(Randomize,2000); // esperem 2 segons i comencem el joc
}


function BaixaGots(){ //Baixa tots els gots

	document.getElementById('c1').style.top="0px";
	document.getElementById('c2').style.top="0px";
	document.getElementById('c3').style.top="0px";
}


function Randomize(){	//Random a el valor de la posicio de la bola

	let xhr = new XMLHttpRequest();
    	let url = "../php/makeRandom.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		console.log("state make random: " + xhr.readyState);
		if (xhr.readyState === 4 && xhr.status === 200)
		{
			if(this.responseText === "0") // random fet
			{
				setTimeout(serverState,500);
				console.log("random fet pot començar el joc");
				ha_clicat=false;
				document.getElementById("result").innerHTML ="GO!!!";
			}
			else if (this.responseText === "-1") // no esta el random fet
			{
				setTimeout(Randomize,500);
			}
			else // error
			{
				console.log("ERROR");
				console.log("this.responseText");
			}

		}
    };

	xhr.send();

}


function serverState()
{

	let xhr = new XMLHttpRequest();
	let url = "../php/serverUpdate.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		console.log("state serverState: " + xhr.readyState);
		if (xhr.readyState === 4 && xhr.status === 200)
		{
			if(this.responseText === "0") // rebut que el rival ha fet alguna cosa
			{
				console.log("algu li ha donat");
				ha_clicat = true;
				setTimeout(Evaluacio,500);
			}
			else if(this.responseText === "-1") // No ha passat res
			{
				console.log("NO HA PASSAT RES AL SERVER");
				setTimeout(serverState,500);

			}
			else // error
			{
				console.log("ERROR SERVER STATE");
				console.log(this.responseText);
			}
		}

	}

	xhr.send();

}


function choiceOne(cupchecked){ //Marca el got que has triat i envia-ho al server

	if(valor_triat_rival == 0 && ha_clicat==false)
	{
		ha_clicat=true;

		var frase_random=Math.floor(Math.random() * missatges_per_entretenir.length);
		document.getElementById("frase").innerHTML=missatges_per_entretenir[frase_random];

		valor_triat=cupchecked;

		let xhr = new XMLHttpRequest();
		let url = "../php/doChoice.php";

		xhr.open("POST", url, true);

		xhr.setRequestHeader("Content-Type", "application/json");

		//console.log("state: " + xhr.readyState);
		xhr.onreadystatechange = function ()
		{
			if (xhr.readyState === 4 && xhr.status === 200)
			{
				if(this.responseText === "0")
				{
					console.log("eleccio feta");
				}
				else if(this.responseText === "-1")
				{
					console.log("no s'ha pogut triar");
					setTimeout(function() {choiceOne(cupchecked);}, 500)
				}
				else // error
				{
					console.log("ERROR APRETAGOT");
					console.log(this.responseText);
				}
			}
		}

		// Converting JSON data to string
		var data = JSON.stringify({ "click": valor_triat });
		// Sending data with the request
		xhr.send(data);

	}
}


function AixecaGot(eleccio, jug)
{

	console.log(eleccio);
	console.log(jug);

	switch(eleccio){ //aixeca got del player
		case '1':
			document.getElementById('c1').style.top="-60px";

			switch(jug)
			{
				case '1':

					document.getElementById("log").innerHTML="<div class='arrow-up-blue' style='left:80px'></div>";
					document.getElementById("ball1").style.visibility="visible";

					break;

				case '2':

					document.getElementById("log_rival").innerHTML="<div class='arrow-up-red' style='left:80px'></div>";
					document.getElementById("ball1").style.visibility="visible";

					break;

				case '3':

					document.getElementById("log").innerHTML="<div class='arrow-up-blue' style='left:80px'></div>";

					break;

				case '4':

					document.getElementById("log_rival").innerHTML="<div class='arrow-up-red' style='left:80px'></div>";

					break;
			}
			break;

		case '2':
			document.getElementById('c2').style.top="-60px";

			switch(jug)
			{
				case '1':

					document.getElementById("log").innerHTML="<div class='arrow-up-blue' style='left:280px'></div>";
					document.getElementById("ball2").style.visibility="visible";

					break;

				case '2':

					document.getElementById("log_rival").innerHTML="<div class='arrow-up-red' style='left:280px'></div>";
					document.getElementById("ball2").style.visibility="visible";

					break;

				case '3':

					document.getElementById("log").innerHTML="<div class='arrow-up-blue' style='left:280px'></div>";

					break;

				case '4':

					document.getElementById("log_rival").innerHTML="<div class='arrow-up-red' style='left:280px'></div>";

					break;
			}
			break;

		case '3':
			document.getElementById('c3').style.top="-60px";

			switch(jug)
			{
				case '1':

					document.getElementById("log").innerHTML="<div class='arrow-up-blue' style='left:480px'></div>";
					document.getElementById("ball3").style.visibility="visible";

					break;

				case '2':

					document.getElementById("log_rival").innerHTML="<div class='arrow-up-red' style='left:480px'></div>";
					document.getElementById("ball3").style.visibility="visible";

					break;

				case '3':

					document.getElementById("log").innerHTML="<div class='arrow-up-blue' style='left:480px'></div>";

					break;

				case '4':

					document.getElementById("log_rival").innerHTML="<div class='arrow-up-red' style='left:480px'></div>";

					break;
			}
			break;
	}
setTimeout(updatePunts,500);
}


function Evaluacio() //Mirar si algu ha guanyat
{

	let xhr = new XMLHttpRequest();
	let url = "../php/evaluate.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		console.log("state Evaluació: " + xhr.readyState);
		if (xhr.readyState === 4 && xhr.status === 200)
		{
			var cup = 0;
			var jug = 0;

			var obj = JSON.parse(this.responseText);

			if(obj.res === "1") // tu gunayes punts
			{
				document.getElementById("result").innerHTML ="YOU WON! +10 POINTS";
				jug = obj.res;
				cup = obj.cup;
				AixecaGot(cup,jug);
			}
			else if (obj.res === "3") // tu perds
			{
				document.getElementById("result").innerHTML ="YOU LOST!";
				jug = obj.res;
				cup = obj.cup;
				AixecaGot(cup,jug);
			}
			else if(obj.res === "2") // Rival guanya punts
			{
				document.getElementById("result").innerHTML ="RIVAL WON! +10 POINTS";
				jug = obj.res;
				cup = obj.cup;
				AixecaGot(cup,jug);
			}
			else if(obj.res === "4") // el rival ha triat pero no ha guanyat punts
			{
				document.getElementById("result").innerHTML ="RIVAL LOST!";
				jug = obj.res;
				cup = obj.cup;
				AixecaGot(cup,jug);
			}
			else //error
			{
				console.log("ERROR");
				console.log(this.responseText);
			}
		}
	}

	xhr.send();

}

function updatePunts()
{

	let xhr = new XMLHttpRequest();
	let url = "../php/puntsUpdate.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		console.log("state UpdatePunts: " + xhr.readyState);
		if (xhr.readyState === 4 && xhr.status === 200)
		{

			var obj = JSON.parse(this.responseText);
			if(obj.res === "0")
			{
				puntuacio_p1 = obj.p1;
				document.getElementById("score_p1").innerHTML = puntuacio_p1;

				puntuacio_p2 = obj.p2;
				document.getElementById("score_p2").innerHTML = puntuacio_p2;

				setTimeout(preReset,700);

			}
			else if(obj.res === "-1")
			{
				console.log("Punts no agafats");
				setTimeout(updatePunts,500);

			}
			else // error
			{
				console.log("ERROR");
				console.log(this.responseText);
			}
		}

	}

	xhr.send();

}


function preReset()
{

	let xhr = new XMLHttpRequest();
	let url = "../php/preReset.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		console.log("state preReset: " + xhr.readyState);
		if (xhr.readyState === 4 && xhr.status === 200)
		{

			if(this.responseText === "0")
			{
				setTimeout(ResetGame,3000); // esperem 3  segons i resetejem el joc
				console.log("ACABAT");
			}
			else if(this.responseText === "-1")
			{
				console.log("preReset no fet");
				setTimeout(preReset,500);

			}
			else // error
			{
				console.log("ERROR");
				console.log(this.responseText);
			}
		}

	}

	xhr.send();

}


