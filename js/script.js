var nameOk = false;
var lastNameOk = false;
var emailOk = false;
var psw = false;
var psw2 = false;

var nombre = document.getElementById("nom");
var lastName = document.getElementById("cognom");
var email = document.getElementById("email");

var myInput = document.getElementById("contra1");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
var pwned = document.getElementById("pwned");

var myInput2 = document.getElementById("contra2");
var equal = document.getElementById("equal");
var subButton = document.getElementById("envia");





function allOKey() {
	if(nameOk && lastNameOk && emailOk && psw && psw2)
	{
		console.log("totOK!");
		subButton.disabled = false;
	}
}
function notOkey() {
	subButton.disabled = true;
}


//nom i cognom
nombre.onblur = function() {
  if(nombre.value === "")
  {
		nombre.classList.remove("validImput");
		nombre.classList.add("invalidImput");
		nameOk = false;
		notOkey();
  }
  else
  {
		nombre.classList.remove("invalidImput");
		nombre.classList.add("validImput");
		nameOk = true;
		allOKey();
  }
}
lastName.onblur = function() {
    if(lastName.value === "")
	{
		lastName.classList.remove("validImput");
		lastName.classList.add("invalidImput");
		lastNameOk = false;
		notOkey();
	}
    else
	{
		lastName.classList.remove("invalidImput");
		lastName.classList.add("validImput");
		lastNameOk = true;
		allOKey();
	}
}



//EMAIL
email.onblur = function() {
	const re = new RegExp (/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
	if(re.test(email.value))
	{
		email.classList.remove("invalidImput");
		email.classList.add("validImput");
		emailOk = true;
		allOKey();
	}
	else
	{
		email.classList.remove("validImput");
		email.classList.add("invalidImput");
		emailOk = false;
		notOkey();
	}
}


//PASSWORD
// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}
// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
   if(myInput.value == "")
  {
        myInput.classList.remove("validImput");
        myInput.classList.add("invalidImput");
  }
}
// When the user starts to type something inside the password field
myInput.onkeyup = function() {
	var lower = false;
	var upper = false;
	var num = false;
	var leng = false;
	var pwn = false;

  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
	lower = true;
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
	lower = false;
  }
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
	upper = true;
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
	upper = false;
  }
  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
	num = true;
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
	num = false;
  }
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
    leng = true;
  }
   else
   {
    	length.classList.remove("valid");
    	length.classList.add("invalid");
	leng = false;
	pwned.classList.remove("valid");
	pwned.classList.add("invalid");
	pwn = false;
  }
  if(leng) // si ens posen una contrasenya valida, mirem si ha estat compromesa
  {
	let xhr = new XMLHttpRequest();
	let url = "../php/pwned.php";

	xhr.open("POST", url, true);

	xhr.setRequestHeader("Content-Type", "application/json");

	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState === 4 && xhr.status === 200)
		{
			console.log(this.responseText);
			if(this.responseText === "0") // contraseya no compromesa
			{
				pwned.classList.remove("invalid");
				pwned.classList.add("valid");
				pwn = true;

				if(lower && upper && num && leng && pwn)
                                {
                                        console.log("ENTRA");
                                         myInput.classList.remove("invalidImput");
                                         myInput.classList.add("validImput");
                                         psw = true;
                                         allOKey();
                                 }
			}
			else if (this.responseText === "-1") // contraseya compromesa
			{
				pwned.classList.remove("valid");
				pwned.classList.add("invalid");
				pwn = false;
			}
			else // error
			{
				console.log("ERROR");
				console.log(this.responseText);
			}

		}
	};

	var data = JSON.stringify({ "pass": myInput.value });
	xhr.send(data);
  }


  if(lower && upper && num && leng && pwn)
  {
	console.log("OK");
	  myInput.classList.remove("invalidImput");
	  myInput.classList.add("validImput");
	  psw = true;
	  allOKey();
  }
  else
  {
	console.log("NOT OK");
	  myInput.classList.remove("validImput");
	  myInput.classList.add("invalidImput");
	  psw = false;
	  notOkey();
  }
}


//Password 2
myInput2.onfocus = function() {
  document.getElementById("message2").style.display = "block";
}
// When the user clicks outside of the password field, hide the message box
myInput2.onblur = function() {
  document.getElementById("message2").style.display = "none";
  if(myInput2.value == "")
  {
		myInput2.classList.remove("validImput");
		myInput2.classList.add("invalidImput");
  }
}
myInput2.onkeyup = function() {
	//validate same psw
	var same = myInput.value == myInput2.value;
	if(same) {
		myInput2.classList.remove("invalidImput");
		myInput2.classList.add("validImput");
		equal.classList.remove("invalid");
		equal.classList.add("valid");
		psw2 = true;
		allOKey();
	} else {
		myInput2.classList.remove("validImput");
		myInput2.classList.add("invalidImput");
		equal.classList.remove("valid");
		equal.classList.add("invalid");
		psw2 = false;
		notOkey();
	}
}

