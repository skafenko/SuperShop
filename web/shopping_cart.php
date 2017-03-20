<?php

include_once("php/start.php");

include_once("php/variables.php");

include_once("php/functions.php");

//---------------------------------------------------------------update $_SESSION['cart']-----------------------------------
if (isset($_POST['renew']))
{
	for ($i = 0, $j = -1; $i < count($_POST) - 1; $i++, $j--)
	{
		if (isset($_POST[$i]))
			$_SESSION['cart'][$i]['amountItem'] = $_POST[$i];
		if (isset($_POST[$j]))
			unset($_SESSION['cart'][$_POST[$j]]);
	}
	$_SESSION['cart'] = array_values($_SESSION['cart']);
	
}

//---------------------------------------------------------------create $_SESSION['cart']-----------------------------------
if (isset($_SESSION['idItem']))
{
	$indexItem = checkIdInSession($_SESSION['idItem']);
	addItemToCart($indexItem);
	unset($_SESSION['idItem']);
	unset($_SESSION['category']);
}

if (empty($_SESSION['cart'] ))
{
	$display = "hidden";
}





?>
<!doctype html>
<html>
<head>
	<title>Shopping_cart</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
	<link rel="stylesheet" href="css/shopping_cart.css" type="text/css">
</head>
<body>
	<?php include("pages/header.php"); ?>
	
	<p>Корзина</p>
	<div id="shopping_cart">
		<form method="POST" action="checkout.php" name="order" id="order">
			<table >
				<tr id="title">
					<th>Товар</th>
					<th></th>
					<th>Доступность</th>
					<th>Стоимость</th>
					<th>Количество</th>
					<th>Итого</th>
					<th></th>
				</tr>
				<?php
				if ($arrayTable != null)
				{
					foreach($arrayTable as $item)
					{
						echo $item;
					}
				}	
				?>
			</table>
			<button type="sumbit" name="renew" class="hidden" id="renew" ></button>
		</form>
		<p>Итого: <span><?php echo $symma." ".$currency;?></span></p>
		<a class="floatLeft" href="index.php" id="countinueButton">Вернуться к покупкам</a>
		<div id="shoppingButton" class="<?php echo $display; ?>"  onClick="document.getElementById('renew').click();">Оформить заказ</div>
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