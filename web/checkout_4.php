<?php 



include("php/start.php");

include("php/variables.php");

include("php/functions.php");


if (isset($_SESSION['cart']) && !isset($_SESSION['idUser']))
{
	createUser();
}

if (isset($_SESSION['cart']) && isset($_SESSION['idUser']))
{
	createOrder();
}



?>
<!doctype html>
<html>
<head>
	<title>Checkout_4</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/checkout_4.css" type="text/css">

</head>
<body>

	<?php include("pages/header.php"); ?>
	
	<p>Оформление заказа</p>
	
	<div id="accordion">
		<div id="order">
			<p>Заказ № <?php echo $_SESSION['idOrder']; ?> <span>успешно оформлен</span></p>
			Спасибо за ваш заказ.<br><br>
			В ближайшее время с вами свяжется оператор для уточнения времени доставки.
		</div>
		<div class="clear"></div>
		<a href="index.php"><div id="confirm">Вернуться в магазин</div></a>
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