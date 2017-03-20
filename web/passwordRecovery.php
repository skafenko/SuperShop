<?php 


include_once("php/start.php");

include_once("php/variables.php");

include_once("php/functions.php");

$errorMessage = "";
if (isset($_POST['recovery']))
{
	$mail = trim($_POST['mail']);
	if(checkMail($mail))
	{
		$userPassword = getPasswordByMail($mail);
		$errorMessage = "(Функция не роботает....Приносим свои извинения...)";
		
	}
	else
	{
		$errorMessage = "(E-mail ".$mail." не существует)";
	}
	
}

?>
<!doctype html>
<html>
<head>
	<title>Login</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/login.css" type="text/css">

</head>
<body>
	<?php include("pages/header.php"); ?>
	<p>Восстановление</p>
	
	<div id="contener">
		
		<form action="" name="login" method="POST">
			<legend class="floatLeft" id="logIn">
			<p>Восстановление пароля <span><?php echo $errorMessage; ?></span></p><br>
				<label for="name">E-mail адрес: <span> <?php echo $mistakeMail; ?> </span></label><br><input type="text" 
																	name="mail" 
																	id="mail"
																	placeholder="<?php echo $placeholderMail; ?>"
																	pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
																	required><br>
				<input type="submit" name="recovery" value="Восстановить">
			</legend>
		</form>
		<div class="clear"></div>
	</div>
	
	
	<footer>
		<ul class="floatLeft">
			<li>Шаблон для экзаменационного задания.</li>
			<li>Разработан специально для «Всероссийской Школы Программирования»</li>
			<li>http://bedev.ru/</li>
		</ul>
		<a href="#">Наверх</a>
	</footer>
</body>
</html>	