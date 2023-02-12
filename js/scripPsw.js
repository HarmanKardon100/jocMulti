var psw = false;
var psw2 = false;

var myInput = document.getElementById("contra1");
var length = document.getElementById("length");

var myInput2 = document.getElementById("contra2");
var equal = document.getElementById("equal");
var subButton = document.getElementById("envia");


function allOKey() {
	if(psw && psw2)
	{
		console.log("totOK!");
		subButton.disabled = false;
	}
}

function notOkey() {
	subButton.disabled = true;
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

myInput.onkeyup = function()
{
	var leng = false;

	// Validate length
	if(myInput.value.length >= 8)
	{
		myInput.classList.remove("invalidImput");
		myInput.classList.add("validImput");
		length.classList.remove("invalid");
		length.classList.add("valid");
		leng = true;
		psw = true;
		allOKey();
	}
	else
	{
		myInput.classList.remove("validImput");
		myInput.classList.add("invalidImput");
		length.classList.remove("valid");
		length.classList.add("invalid");
		leng = false;
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
