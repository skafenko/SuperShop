<?php 


include_once("php/start.php");

include_once("php/variables.php");

include_once("php/functions.php");

if (isset($_SESSION['idUser']))
{
	echo "Страница не доступна для авторизованих пользователей   <br><a style='font-size:22px;' href='index.php'>Перейти на главную</a>";
	exit(0);
}

if (isset($_POST['logIn']))
{
	if (trim($_POST['mail']) == $adminMail && trim($_POST['password']) == $adminPassword)
	{
		$_SESSION['adminMail'] = trim($_POST['mail']);
		$_SESSION['adminPassword'] = trim($_POST['password']);
		include_once("users.php");
		exit();
	}
	
	if (checkMail(trim($_POST['mail'])) === false)
	{
		$mistakeMail = "(E-mail адреса не существует!)";
	}
	else if (getPasswordByMail(trim($_POST['mail'])) != trim($_POST['password']))
	{
		$mail = trim($_POST['mail']);
		$mistakeOldPassword = "(Парол не верный!)";
	}
	else
	{
		$_SESSION['idUser'] = getUserByMail(trim($_POST['mail']));
		getArrayCartFromBD($_SESSION['idUser'], $users);
		include_once("index.php");
		exit();
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
	<p>Вход</p>
	
	<div id="contener">
		
		<form action="" name="login" method="POST">
			<legend class="floatLeft" id="logIn">
			<p>Зарегистрированный пользователь</p><br>
				<label for="name">E-mail адрес: <span> <?php echo $mistakeMail; ?> </span></label><br><input type="text" 
																	name="mail" 
																	id="mail"
																	placeholder="<?php echo $placeholderMail; ?>"
																	value="<?php echo $mail; ?>"
																	pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
																	required><br>
				<label for="password">Пароль:<span> <?php echo $mistakeOldPassword; ?> </span></label><br><input type="password" 
																name="password" 
																id="password"
																placeholder="Ваш пароль"
																title="Минимум одна цифра, одна буква в верхнем регистре и одна в нижнем.Тольки Латинские буквы!!"
																pattern="(?=^.{3,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*"
																required><br>
				<input type="submit" name="logIn" value="Войти">
				<a href="passwordRecovery.php">Забыли пароль</a>
			</legend>
		</form>
		<p>Новый пользователь</p><br>
		<a href="register.php"><div id="register">Зарегистрироваться</div></a>
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