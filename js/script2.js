var emailOk = false;
var psw = false;
var email = document.getElementById("email");
var myInput = document.getElementById("contra1");
var subButton = document.getElementById("envia");


function allOkey() {
	if(emailOk && psw)
	{
		subButton.disabled = false;
	}
}
function notOkey() {
	subButton.disabled = true;
}


//EMAIL
email.onblur = function() {
	const re = new RegExp (/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
	if(re.test(email.value))
	{
		email.classList.remove("invalidImput");
		email.classList.add("validImput");
		emailOk = true;
		allOkey();
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
// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {

   if(myInput.value == "")
  {
        myInput.classList.remove("validImput");
        myInput.classList.add("invalidImput");
	psw = false;
	notOkey();
  }
  else
  {
	myInput.classList.remove("invalidImput");
	myInput.classList.add("validImput");
	psw = true;
	allOkey();
  }
}
