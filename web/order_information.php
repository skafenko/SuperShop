<?php

include_once("php/start.php");

include_once("php/admin_control.php");

include_once("php/variables.php");

include_once("php/functions.php");

if (isset($_POST['idOrder']))
{
	$arrayOrder = getOrder($_POST['idOrder']);
	
	switch($arrayOrder['status'])
	{
		case "принят":
			$class = $classBlue;
			break;
		case "отгружен":
			$class = $classGreen;
			break;
		case "у курьера":
			$class = $classYellow;
			break;
		case "доставлен":
			$class = $classPink;
			break;
		case "отмена":
			$class = $classGray;
	}
	$User = getUser($arrayOrder['userid']);
	getArrayCartFromBD($_POST['idOrder'], $orders);
}
else
{
	include_once("orders.php");
	exit();
}


?>
<!doctype html>
<html>
<head>
	<title>Order Information</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/order_information.css" type="text/css">

	<link rel="stylesheet" href="js/alertify/themes/alertify.core.css" />
	<link rel="stylesheet" href="js/alertify/themes/alertify.default.css" id="toggleCSS" />
	<script src="js/alertify/lib/alertify.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script>
	function deleteItemFromCart(indexCart, idOrder)
	{
		var total = document.getElementById('total');
		var totalText = total.innerText;
		var totalSymma = totalText.substring(0,totalText.indexOf(" "));
		
		var currency = totalText.substring(totalText.indexOf(" "));
		
		var itemSymmaText = document.getElementById('symma' + indexCart).innerText;
		var itemSymma = itemSymmaText.substring(0,itemSymmaText.indexOf(" "));

		var doc = document.getElementById('tr' + indexCart).style.display = "none";
		
		total.innerText = (totalSymma - itemSymma) + currency;
	
		$.ajax({
			type:"post",
			url:"php/changeOrderCart.php",
			data:
			{
				indexCart: indexCart,
				idOrder: idOrder
			},
			success: function(html)
			{
				alertify.alert( html, function () { 
					var form = document.getElementById('form' + indexCart);
					form.setAttribute("method", "post");
					form.setAttribute("action", "orders.php");
					document.forms['form' + indexCart].submit();
				});
			},
			cache:false,
			
		});
		
		return false;
	}
	</script>
</head>
<body>
	<div id="wrapper">
	
			<?php include("php/admin_aside.php"); ?>
			
			<div id="content">
				<h1>ЗАКАЗЫ <span>№<?php echo $_POST['idOrder']; ?> </span><i class="<?php echo $class; ?>">(<?php echo $arrayOrder['status']; ?>)</i></h1>
				<div class="order">
						<table id="table">
						<caption>содержимое заказа</caption>
						<?php 
							for ($i = 0; $i < count($_SESSION['cart']); $i++)
							{
								$Item = getItemsById($_SESSION['cart'][$i]['idItem']);
								$Item = getItemsById($_SESSION['cart'][$i]['idItem']);
								if (isset($_SESSION['cart'][$i]['variant']))
									$variantForCart = $_SESSION['cart'][$i]['variant'];
								$symmaItem = $Item[0]['price'] * $_SESSION['cart'][$i]['amountItem'];
								$symmaCheck += $symmaItem;
								echo    "<tr id='tr".$i."'>
											<td>
												".$Item[0]['nameitem']."
											</td>
											<td>".$variantForCart."</td>
											<td>".$Item[0]['price']." ".$currency."</td>
											<td>
												<span>".$_SESSION['cart'][$i]['amountItem']."</span>
											</td>
											<td id='symma".$i."'>".$symmaItem." ".$currency."</td>
											<td><form id='form".$i."' onClick='deleteItemFromCart(".$i.", ".$_POST['idOrder'].");'><button type='submit' class='hidden'></button>убрать из заказа</form></td>
										</tr>";
							}
						$_SESSION['copyCart'] = $_SESSION['cart'];
						unset($_SESSION['cart']);
						?>
						</table>
						<div class="span" id="total"><?php echo $symmaCheck." ".$currency;?></div>
						<div class="p">Итоговая <br>сумма</div>
						<div class="clear"></div>
				</div>
				<div class="information">
					<p>Информация о заказе</p>
					<ul>
						<li>
							<ul id="customer">
								<li><p>Контактное лицо (ФИО):<br><span><?php echo $User[0]['fio']; ?></span></p></li>
								<li><p>Контактный телефон:<br><span><?php echo $User[0]['phone']; ?></span></p></li>
								<li><p>E-mail:<br><span><?php echo $User[0]['mail']; ?></span></p></li>
							</ul>
						</li>
						<li>
							<ul id="adress">
								<li><p>Город:<br><span><?php echo $arrayOrder['town']; ?></span></p></li>
								<li><p>Улица:<br><span><?php echo $arrayOrder['street']; ?></span></p></li>
								<li class="floatLeft" ><p>Дом<br><span><?php echo $arrayOrder['house']; ?></span></p></li>
								<li><p>Квартира<br><span><?php echo $arrayOrder['flat']; ?></span></p></li>
							</ul>
						</li>
						<li>
							<ul id="delivery">
								<li><p>Способ доставки:<br><span><?php echo $arrayOrder['delivery']; ?></span></p></li>
								
							</ul>
						</li>
					</ul>
					
					<div id="comment"><p>Комментарий к заказу:<br><span><?php echo $arrayOrder['comment']; ?></span></p></div>
				</div>
				<form action="orders.php" name="cancel" method="POST" ><input type="submit"  value="Отменить заказ" name="cancel"></input></form>
				<form action="orders.php" name="delete" method="POST" ><input type="submit"  value="Удалить заказ" name="delete"></input></form>
			</div>
			
	</div>
</body>
</html>