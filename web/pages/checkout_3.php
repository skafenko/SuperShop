<?php
if (isset($_SESSION['cart']))
{	
	$tableCheck =  array();
	foreach ($_SESSION['cart'] as $arrayCart)
	{
		$arrayItem = getItemsById($arrayCart['idItem']);
		$symmaItem = $arrayItem[0]['price'] * $arrayCart['amountItem'];
		$symmaCheck += $symmaItem;
		if (isset($arrayCart['variant']))
			$variantForCart = $arrayCart['variant'];
		$table =  "<tr>
				<td>
					".$arrayItem[0]['nameitem']."
				</td>
				<td>".$variantForCart."</td>
				<td>".$arrayItem[0]['price']." ".$currency."</td>
				<td>".$arrayCart['amountItem']."</td>
				<td>".$symmaItem." ".$currency."</td>
			</tr>";
		array_push($tableCheck, $table);
		$variantForCart = "";
	}
}

?>
<div id="check" class="<?php echo $step3; ?>">
	<table id="table">
		<caption>Состав заказа:</caption>
		<tr id="titleTable">
			<th>Товар</th>
			<th>Вариант</th>
			<th>Стоимость</th>
			<th>Количество</th>
			<th>Итого</th>
		</tr>
		<?php 
			if ($tableCheck != "")
			{
				foreach($tableCheck as $itemCheck)
				{
					echo $itemCheck;
				}
			}	
		?>
	</table>
	<p>Итого: <span><?php echo $symmaCheck." ".$currency;?></span></p>
	<ul id="deliveryCheck">
	<p><p>Доставка:</p>
		<li>
			<ul class="floatLeft" id="customer">
				<li><p>Контактное лицо (ФИО):<br><span><?php echo $_SESSION['fio']; ?></span></p></li>
				<li><p>Контактный телефон:<br><span><?php echo $_SESSION['phone']; ?></span></p></li>
				<li><p>E-mail:<br><span><?php echo $_SESSION['mail']; ?></span></p></li>
			</ul>
		</li>
		<li>
			<ul class="floatLeft" id="adressCheck">
				<li><p>Город:<br><span><?php echo $_SESSION['town']; ?></span></span></p></li>
				<li><p>Улица:<br><span><?php echo $_SESSION['street']; ?></span></span></p></li>
				<li class="floatLeft" ><p>Дом<br><span><?php echo $_SESSION['house']; ?></span></p></li>
				<li><p>Квартира<br><span><?php echo $_SESSION['flat']; ?></span></p></li>
			</ul>
		</li>
		<li>
			<ul id="comment">
				<li><p>Способ доставки:<br><span><?php echo $_SESSION['delivery']; ?></span></p></li>
				<li><p>Комментарий к заказу:<br><span><?php echo $_SESSION['yourComment']; ?></span></p></li>
			</ul>
		</li>
	</ul>
	<div class="clear"></div>
	<a href="checkout_4.php" id="confirm">Подтвердить заказ</a>
</div>