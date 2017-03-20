<?php

include_once("php/start.php");

include_once("php/admin_control.php");

include_once("php/variables.php");

include_once("php/functions.php");

$arrayUser = array();
if (isset($_POST['idUsera']))
{
	$arrayUser = getUser($_POST['idUsera'])[0];
	$_SESSION['idUsera'] = $_POST['idUsera'];
}
else
{
	include_once("users.php");
	exit();
}

$arrayOrders = getOrdersByUser($arrayUser['id']);

$total = 0;

?>
<!doctype html>
<html>
<head>
	<title>User Information</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
	<link rel="stylesheet" href="css/user_information.css" type="text/css">
	
</head>
<body>
	<div id="wrapper">
			<?php include("php/admin_aside.php"); ?>
			<div id="content">
				<h1>Просмотр пользователя</h1>
				<div class="information">
					<p>Информация о пользователя</p>
					<ul>
						<li>
							<ul id="customer">
								<li><p>Контактное лицо (ФИО):<br><span><?php echo $arrayUser['fio']; ?></span></p></li>
								<li><p>Контактный телефон:<br><span><?php echo $arrayUser['phone']; ?></span></p></li>
								<li><p>E-mail:<br><span><?php echo $arrayUser['mail']; ?></span></p></li>
							</ul>
						</li>
						<li>
							<ul id="adress">
								<li><p>Город:<br><span><?php echo $arrayUser['town']; ?></span></p></li>
								<li><p>Улица:<br><span><?php echo $arrayUser['street']; ?></span></p></li>
								<li class="floatLeft" ><p>Дом<br><span><?php echo $arrayUser['house']; ?></span></p></li>
								<li><p>Квартира<br><span><?php echo $arrayUser['flat']; ?></span></p></li>
							</ul>
						</li>
					</ul>
					<div class="clear"></div>
				</div>
				<div class="order">
						<table id="table">
						<caption>История заказов</caption>
						<?php
							if (!empty($arrayOrders))
							{
								foreach ($arrayOrders as $order)
								{
									$date = date_create_from_format('Y-m-d H:i', $order['date']);
									$date =  date_format($date, 'd.m.Y в H:i');
									echo "<tr>
											<td>
												№".$order['id']." 
											</td>
											<td>".$order['symma']." ".$currency."</td>
											<td>
												".$date."
											</td>
										</tr>";
									$total += $order['symma'];
								}
							}
					
						?>
						</table>
						<div class="span"><?php echo $total." ".$currency; ?></div>
						<div class="p">Итоговая <br>сумма заказов</div>
						<div class="clear"></div>
				</div>
				
				<form action="users.php" method="POST"><input type="submit" name="deleteUsera" value="Удалить пользователя"></form>
			</div>
			
	</div>
</body>
</html>