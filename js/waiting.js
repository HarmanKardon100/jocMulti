
setTimeout(first,100);



function first()
{
	console.log("entrem a first");
	let xhr = new XMLHttpRequest();
 	let url = "../php/first.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState === 4 && xhr.status === 200)
		{
			if(this.responseText === "0")
			{
				console.log("enviem altre cop");
				second();
			}
			else if (this.responseText === "-1")
			{
				console.log("no s'ha pugut connectar");
				setTimeout(first,500);
			}
			else
			{
				console.log("ERROR");
				console.log(this.responseText);
			}
		}
    }

	// Sending data with the request
	xhr.send();


}


function second()
{
	console.log("entrem a second");
	let xhr = new XMLHttpRequest();
	let url = "../php/second.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState === 4 && xhr.status === 200)
		{
			var obj = JSON.parse(this.responseText);
			if(obj.res === "0")
			{
				console.log("latencia: " + obj.ping + " ms");
				setTimeout(connect,200); // tenim latencia calculada, anem a contectar amb una partida
			}
			else if (obj.res === "-1")
			{
				console.log("no s'ha tornat ping");
				setTimeout(first,500); // tornem a intentar calcular ping
			}
			else
			{
				console.log("ERROR");
				console.log(obj.res);
			}
		}
    }

	// Sending data with the request
	xhr.send();

}



function connect()
{
	 console.log("entrem a connect");
	let xhr = new XMLHttpRequest();
    	let url = "../php/connectReq.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState === 4 && xhr.status === 200)
		{
			if(this.responseText == 0)
			{
				console.log("connectat, toca buscar oponent");
				setTimeout(searchOpponent,200);
			}
			else if (this.responseText == -1)
			{
				console.log("no es connecta");
				setTimeout(connect,500);
			}
			else
			{
				console.log("ERROR");
				console.log(this.responseText);
			}
		}
    	}

	// Converting JSON data to string
	var data = JSON.stringify({ "connect": 1 });
	// Sending data with the request
	xhr.send(data);


}

function searchOpponent()
{
	 console.log("entrem a search");
	let xhr = new XMLHttpRequest();
	let url = "../php/opponentsReady.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState === 4 && xhr.status === 200)
		{
			console.log(this.responseText);
			if(this.responseText === "-1") // encara no hi ha 2 jugadors
			{
				setTimeout(searchOpponent,500);
			}
			else if (this.responseText === "0") // ja hi ha 2 jugadors
			{
				console.log("preparats per jugar");
				window.location.replace("../game.php");
			}
			else // error
			{
				console.log("ERROR");
				console.log(this.responseText);
			}
		}
	}

	// Sending data with the request
	xhr.send();

}
