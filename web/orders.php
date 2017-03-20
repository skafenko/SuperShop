<?php

include_once("php/start.php");

include_once("php/admin_control.php");

include_once("php/variables.php");

include_once("php/functions.php");

if (isset($_POST['cancel']))
{
	changeOrderStatusById($_SESSION['idOrder'], "отмена");
}

if (isset($_POST['delete']))
{
	deleteOrderById($_SESSION['idOrder']);
}

$arrayOrders = getOrders();

?>
<!doctype html>
<html>
<head>
	<title>Orders</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/orders.css" type="text/css">

	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script>
	function send(id)
	{
		var element = document.getElementById(id);
		var value = element.value;
		
		$.ajax({
			type:"post",
			url:"php/changeOrderStatus.php",
			data:
			{
				status: value,
				idOrder: id
			},
			cache:false,
			
		});
		var form = document.getElementById('form' + id).submit;
		return false;
	}
	</script>
</head>
<body>
	<div id="wrapper">
	
			<?php include("php/admin_aside.php"); ?>
			
			<div id="content">
			<p id="sss"></p>
				<h1>ЗАКАЗЫ</h1>
				<table>
					<tr>
						<th>Номер заказа </th>
						<th>статус</th>
						<th>сумма</th>
						<th>время заказа</th>
						<th></th>
					</tr>
					<?php
						if (!empty($arrayOrders))
						{
							foreach ($arrayOrders as $order)
							{
								$mail = getUser($order['userid'])[0]['mail'];
								$date = date_create_from_format('Y-m-d H:i', $order['date']);
								$date =  date_format($date, 'd.m.Y в H:i');
								$status = $order['status'];
								$selectedGray = checkStatus($status, "отмена", $classGray);
								$selectedPink = checkStatus($status, "доставлен", $classPink);
								$selectedYellow = checkStatus($status, "у курьера", $classYellow);
								$selectedGreen = checkStatus($status, "отгружен", $classGreen);
								$selectedBlue = checkStatus($status, "принят", $classBlue);
								echo "<tr>
											<td>
												<p>№".$order['id']."<span> от </span><strong>".$mail."</strong></p>
											</td>
											<td>
												<form id='form".$order['id']."'>
													<label>
														<select name='status' id='".$order['id']."' class=".$class." onClick='this.className=this.options[this.selectedIndex].className' onChange='return send(".$order['id'].");'>
															<option value='принят' class='blueText' ".$selectedBlue.">принят</option>
															<option value='отгружен' class='greenText' ".$selectedGreen.">отгружен</option>
															<option value='у курьера' class='yellowText' ".$selectedYellow.">у курьера</option>
															<option value='доставлен' class='pinkText' ".$selectedPink.">доставлен</option>
															<option value='отмена' class='grayText' ".$selectedGray.">отмена</option>
														</select>
													</label>
												</form>
											</td>
											<td>".$order['symma']." ".$currency."</td>
											<td>".$date."</td>
											<td>
												<form action='order_information.php' name='lookOrder' id='lookOrder' method='POST'>
													<input type='text' name='idOrder' id='idOrder' value='".$order['id']."'>
													<input type='submit' name='look' value='просмотр'>
												</form>
											</td>
									</tr>";
							}
						}
					?>
					
				</table>
				<div class="clear"></div>
			</div>
	</div>
</body>
</html>