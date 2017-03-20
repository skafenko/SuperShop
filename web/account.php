<?php

include("php/start.php");

include("php/variables.php");

include("php/functions.php");

mb_internal_encoding('UTF-8');

if (isset($_SESSION['idUser']))
{
	if (isset($_POST['save']))
	{
		saveUser($_SESSION['idUser']);
	}
	
	$userArray = getUser($_SESSION['idUser']);
	$orderArray = getOrdersByUser($_SESSION['idUser']);
	
	$fio = $userArray[0]['fio'];
	$phone = $userArray[0]['phone'];
	$mail = $_SESSION['mail'] = $userArray[0]['mail'];
	$town = $userArray[0]['town'];
	$house = $userArray[0]['house'];
	$street = $userArray[0]['street'];
	$flat = $userArray[0]['flat'];
}


?>
<!doctype html>
<html>
<head>
	<title>Account</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/account.css" type="text/css">
</head>
<body>
	<?php include("pages/header.php"); ?>
	<p>Личный кабинет</p>
	
	<div id="contener">
		<form class="floatLeft" action="" method="POST" name="login">
			<legend  id="user">
			<p>Ваши данные <span> <?php echo $adminInformation; ?></span></p><br>
				<label for="fio">Контактное лицо (ФИО):</label><br><input type="text" 
																	name="fio" 
																	title="Пример : Петров Петр Петрович"
															pattern="^\s*([A-Za-zА-Яа-яЁё]+\s+){1}([A-Za-zА-Яа-яЁё]+\s*){1}([A-Za-zА-Яа-яЁё]+)*\s*$"  
																	id="fio"
																	placeholder="ФИО"																	
																	value="<?php echo $fio;?>"><br>
				<label for="phone">Контактный телефон:</label><br><input type="text" 
																	name="phone" 
																	id="phone" 
																	title="Введите ваш номер" 
																	placeholder="Ваш телефон" 
																	pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" 
																	value="<?php echo $phone;?>"><br>
				<label for="mail">E-mail: <span><?php echo $mistakeMail; ?></span></label><br><input type="text" 
																							name="mail" 
																							id="mail" 
																							pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
																							placeholder="<?php echo $placeholderMail; ?>" 																						
																							value="<?php echo $mail;?>"><br>
			</legend>
			<legend id="adress">
				<p>Адрес доставки</p><br>
				<label for="town">Город:</label><br><input type="text" 
													name="town" 
													id="town"
													title="Только русские букви"													
													placeholder="Ваш город"
													pattern="^[A-Za-zА-Яа-яЁё-\s]+$" 
													value="<?php echo $town;?>"><br>
				<label for="street">Улица:</label><br><input type="text" 
													name="street" 
													id="street"
													title="Только русские букви, цифры и точка"													
													placeholder="Ваша улица"													
													pattern="^[A-Za-zА-Яа-яЁё0-9.-\s]+$"  
													value="<?php echo $street;?>"><br>
				<div class="floatLeft"><label for="house">Дом:</label><br><input type="text" 
																				name="house" 
																				id="house" 
																				title="Только русские букви, цифры и тире"													
																				placeholder="Ваш дом"
																				pattern="^[A-Za-zА-Яа-яЁё0-9-\s]+$" 
																				value="<?php echo $house;?>"></div>
				<label for="flat">Квартира:</label><br><input type="text" 
																name="flat" 
																id="flat" 
																title="Только русские букви, цифры и тире"													
																placeholder="Ваша квартира"
																pattern="^[0-9\s]+$" 
																value="<?php echo $flat;?>"><br>
			</legend>
			<legend id="yourPassword">
			    <p>Изменение пароля</p><br>
				<label for="oldPassword">Старый пароль: <span><?php echo $mistakeOldPassword; ?></span></label><br><input type="password" 
																name="oldPassword"
																onKeyUp="requirePasswordField();"																
																id="oldPassword"
																placeholder="Введите старый пароль"
																title="Минимум одна цифра, одна буква в верхнем регистре и одна в нижнем.Тольки Латинские буквы!!"
																pattern="(?=^.{3,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*"><br>
				<label for="password">Новый пароль:</label><br><input type="password" 
																name="password"
																onKeyUp="my();"																
																id="password"
																placeholder="Придумайте новый пароль"
																title="Минимум одна цифра, одна буква в верхнем регистре и одна в нижнем.Тольки Латинские буквы!!"
																pattern="(?=^.{3,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*"><br>
				<label for="repeatPassword">Повторите пароль:</label><br><input type="password" 
																			name="repeatPassword" 
																			id="repeatPassword"
																			placeholder="Повторите новый пароль"
																			title="Минимум одна цифра, одна буква в верхнем регистре и одна в нижнем.Тольки Латинские буквы!!"
																			pattern="(?=^.{3,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*"><br>
			</legend>
			<input type="submit" name="save" value="Сохранить">
		</form>
		<div id="orders">
				<p>Ваши заказы</p><br>
				<?php
					if (!empty($orderArray))
					{
						foreach ($orderArray as $order)
						{
							$date = date_create_from_format('Y-m-d H:i', $order['date']);
							$date =  date_format($date, 'd.m.Y в H:i');
							$status = ucfirst(mb_convert_case($order['status'], MB_CASE_TITLE));
							echo "<div>
										<div class='number floatLeft'>№".$order['id']."<br>
															<span>(".$order['id']." ".$currency.")</span><br>
													<span>".$date."</span>
										</div>
										<div class='status'>".$status."</div>
									</div>
									<div class='clear'></div>";
						}
					}
			
				?>
		</div>
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