<?php



include("php/start.php");

include("php/variables.php");

include("php/functions.php");

if (isset($_POST['logIn']))
{
	if (trim($_POST['yourMail']) == $adminMail && trim($_POST['yourPassword']) == $adminPassword)
	{
		$_SESSION['adminMail'] = trim($_POST['mail']);
		$_SESSION['adminPassword'] = trim($_POST['password']);
		include_once("users.php");
		exit();
	}
	
	if (checkMail(trim($_POST['yourMail'])) === false)
	{
		$mistakeMail = "(E-mail адреса не существует!)";
	}
	else if (getPasswordByMail(trim($_POST['yourMail'])) != trim($_POST['yourPassword']))
	{
		$yourMail = trim($_POST['yourMail']);
		$mistakeOldPassword = "(Парол не верный!)";
	}
	else
	{
		$_SESSION['idUser'] = getUserByMail(trim($_POST['yourMail']));
		$isCart = getArrayCartFromBD($_SESSION['idUser'], $users);
		if ($isCart === true)
		{
			include("shopping_cart.php");
			exit();
		}
			
	}
}

if (isset($_SESSION['idUser']))
{
	$ourUser = getUser($_SESSION['idUser']);
	$_SESSION['fio'] = $ourUser[0]['fio'];
	$_SESSION['phone'] = $ourUser[0]['phone'];
	$_SESSION['mail'] = $ourUser[0]['mail'];
	$town = $ourUser[0]['town'];
	$street = $ourUser[0]['street'];
	$house = $ourUser[0]['house'];
	$flat = $ourUser[0]['flat'];
	$step1 = "hidden";
	$step2 = "";
	$checked1 = "";
	$checked2 = "checked";
}

if (isset($_POST['continue']))
{
	$fio = $_SESSION['fio'] = trim($_POST['fio']);
	$phone = $_SESSION['phone'] = trim($_POST['phone']);
	if (checkMail(trim($_POST['mail'])))
	{
		$placeholderMail = "E-mail is exists. Try to logIn";
	}
	else
	{
		$mail = $_SESSION['mail'] = trim($_POST['mail']);
		$step1 = "hidden";
		$step2 = "";
		$checked1 = "";
		$checked2 = "checked";
	}
		
}

if (isset($_POST['continue2']))
{
	$_SESSION['town'] = trim($_POST['town']);
	$_SESSION['street'] = trim($_POST['street']);
	$_SESSION['house'] = trim($_POST['house']);
	$_SESSION['flat'] = trim($_POST['flat']);
	$_SESSION['delivery'] = trim($_POST['delivery']);
	$_SESSION['yourComment'] = trim($_POST['yourComment']);
	$step1 = "hidden";
	$step2 = "hidden";
	$step3 = "";
	$checked1 = "";
	$checked2 = "";
	$checked3 = "checked";
}




?>

<!doctype html>
<html>
<head>
	<title>Checkout</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/checkout.css" type="text/css">
	
	<script type="text/javascript" src="js/checkout.js"></script>
</head>
<body>
	<?php include("pages/header.php"); ?>
	
	<p>Оформление заказа</p>
	
	<div id="accordion" >
		<div id="title" class="<?php echo $checked1; ?>"><p>
							<span>1.</span> 
							Контактная информация
						</p>
		</div>
		<div id="wrap" class="<?php echo $step1; ?>">
			<div class="floatLeft" id="newCustomer">
				<p>Для новых покупателей</p>
				<form action="" name="user" method="POST">
					<label for="fio">Контактное лицо (ФИО):</label><br><input type="text" name="fio" id="fio" 
																			value="<?php echo $fio; ?>" placeholder="ФИО" 
																			pattern="^\s*([A-Za-zА-Яа-яЁё]+\s+){1}([A-Za-zА-Яа-яЁё]+\s*){1}([A-Za-zА-Яа-яЁё]+)*\s*$" 
																			title="Пример : Петров Петр Петрович" required ><br>
					<label for="phone">Контактный телефон:</label><br><input type="text" name="phone" id="phone" 
																			value="<?php echo $phone; ?>" placeholder="Ваш телефон" 
																			pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" required><br>
					<label for="mail">E-mail: </label><br><input type="text" 
																name="mail" 
																id="mail"
																value="<?php echo $mail; ?>" 
																placeholder="<?php echo $placeholderMail; ?>" 
																pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required><br>
					<input type="submit" name="continue" value="Продолжить">
				</form>
			</div>
			<div id="login" class="floatLeft">
				<p>Быстрый вход</p>
				<form action="" name="login" method="POST">
					<label for="yourMail">Ваш e-mail: <span> <?php echo $mistakeMail; ?> </span></label><br><input type="text" 
																		name="yourMail" 
																		id="yourMail"
																		value="<?php echo $yourMail; ?>" 
																		placeholder="<?php echo $placeholderMail; ?>" 
																		pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" 
																		required><br>
					<label for="yourPassword">Пароль: <span> <?php echo $mistakeOldPassword; ?> </span></label><br><input 
																								type="password" 
																								name="yourPassword" 
																								id="yourPassword"
																								placeholder="Ваш пароль"
																								title="Минимум одна цифра, одна буква в верхнем регистре и одна в нижнем.Тольки Латинские буквы!!"
																								pattern="(?=^.{3,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*"
																								required><br>
					<input type="submit" name="logIn" value="Войти"><a href="passwordRecovery.php">Восстановить пароль</a>
				</form>
			</div>
			<div class="clear"></div>
		</div>
		
		<div id="tabs">
			<div id="step2" class="<?php echo $checked2; ?>"><p>
							<span>2.</span> 
							Информация о доставке
						</p>
			</div>
			
			<?php include("pages/checkout_2.php"); ?>
			
			<div id="step3" class="<?php echo $checked3; ?>"><p>
							<span>3.</span> 
							Подтверждение заказа
						</p>
			</div>
			
			<?php include("pages/checkout_3.php"); ?>
			
		</div>
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