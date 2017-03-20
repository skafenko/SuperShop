function makePatternForPassword()
{
	var password = document.getElementById('password').value;
	var repeatPassword = document.getElementById('repeatPassword');
	repeatPassword.pattern = password;
}
function requirePasswordField()
{
	document.getElementById('password').required = true;
	document.getElementById('repeatPassword').required = true;
}
