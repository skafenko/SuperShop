<?php


include("php/start.php");

include("php/variables.php");

include("php/functions.php");
if (isset($_SESSION['idUser']))
{
	echo "Страница не доступна для авторизованих пользователей   <br><a style='font-size:22px;' href='index.php'>Перейти на главную</a>";
	exit(0);
}

if (isset($_POST['mail']))
{
	$fio = trim($_POST['fio']);
	$phone = trim($_POST['phone']);
	if (checkMail(trim($_POST['mail'])))
	{
		$placeholderMail = "E-mail is exists. Try to logIn";
	}
	else
	{
		createUserByRegistration();
		include("index.php");
		exit();
	}
}


?>
<!doctype html>
<html>
<head>
	<title>Register</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/register.css" type="text/css">

</head>
<body>
	<?php include("pages/header.php"); ?>
	
	<p>Регистрация</p>
	<div id="create">
		<form action="" method="POST" name="register">
			<legend class="floatLeft" id="yourName">
				<label for="name">Контактное лицо (ФИО):</label><br>
				<input type="text" name="fio" id="name" placeholder="ФИО" 
						pattern="^\s*([A-Za-zА-Яа-яЁё]+\s+){1}([A-Za-zА-Яа-яЁё]+\s*){1}([A-Za-zА-Яа-яЁё]+)*\s*$" title="Пример : Петров Петр Петрович" value="<?php echo $fio; ?>" required ><br>
				<label for="phone">Контактный телефон :</label><br>
				<input type="tel" name="phone" id="phone" value="<?php echo $phone; ?>" title="Введите ваш номер" placeholder="Ваш телефон" 
						pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" required><br>
				<div id="allMail" class="hidden"><?php echo $stringAllMail; ?></div>
				<label for="mail">E-mail адрес:</label><br><input  type="text"
															placeholder="<?php echo $placeholderMail; ?>" 
															pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" 
															name="mail" id="mail" required><br>
				<input type="submit" value="Зарегистрироваться">
			</legend>
			<legend id="yourPassword">
				<label for="password">Пароль:</label><br><input onKeyUp="makePatternForPassword();" 
														title="Минимум одна цифра, одна буква в верхнем регистре и одна в нижнем.Тольки Латинские буквы!!" 
														type="password" placeholder="Придумайте пароль" name="password" id="password" 
														pattern="(?=^.{3,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*" required><br>
				<label for="repeatPassword">Повторите пароль:</label><br><input placeholder="Повторите пароль" required type="password" 
																			name="repeatPassword" id="repeatPassword"><br>
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
	<script type="text/javascript" src="js/register.js"></script>
</body>
</html>	