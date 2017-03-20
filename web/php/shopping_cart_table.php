<?php
if (isset($_SESSION['cart']))
{	
	$arrayTable =  array();
	$numberId = 0;
	$labelForDelete = -1;
	foreach ($_SESSION['cart'] as $arrayCart)
	{
		
		$arrayItem = getItemsById($arrayCart['idItem']);
		$srcImageCart = $items."/".$arrayItem[0]['category']."/".$arrayCart['idItem'];
		$symmaItem = $arrayItem[0]['price'] * $arrayCart['amountItem'];
		$symma += $symmaItem;
		if (isset($arrayCart['variant']))
			$variantForCart = $arrayCart['variant']."<br><br>";
		if ($arrayItem[0]['label'] != "no" ) 
			$tag = "<img src='images/".$arrayItem[0]['label'].".png' alt='".$arrayItem[0]['label']."'>";
		
		$table =  "<tr id='".$labelForDelete ."'>
				<td>
					".$tag."
					<img src='".$srcImageCart."/1.jpg' alt='two-wheeled skates-15_1' height='178px'>
				</td>
				<td>".$arrayItem[0]['info']."</td>
				<td><span>".$variantForCart."</span>".$arrayItem[0]['status']."</td>
				<td>".$arrayItem[0]['price']." ".$currency."</td>
				<td>
					<div id='margin'>
						<div id='minus' onClick='minus(".$numberId.");' class='cue left'><span>-</span></div>
						<input type='text' name='".$numberId."' id='".$numberId."' value='".$arrayCart['amountItem']."' readonly />
						<div id='plus' onClick='plus(".$numberId.");' class='cue right'><span>+</span></div>
					</div>
				</td>
				<td>".$symmaItem." ".$currency."</td>
				<td><img src='images/delete.png' alt='delete' onClick='deleteItem(".$labelForDelete.", ".$numberId.");'></td>
			</tr>";
		array_push($arrayTable, $table);
		$numberId++;
		$labelForDelete--;
		$variantForCart = "";
	}
	$_SESSION['symma'] = $symma;
}
?>
<script>
	function minus(numberId)
	{
		var item = document.getElementById(numberId);
		var amountItem = parseInt(item.value);
		if (amountItem == 1)
			return;
		amountItem -= 1;
		item.value = amountItem;
		changeShoppingButton();
	}
	
	function plus(numberId)
	{
		var item = document.getElementById(numberId);
		var amountItem = parseInt(item.value);
		amountItem += 1;
		item.value = amountItem;
		changeShoppingButton();
	}
	
	function changeShoppingButton()
	{
		var shoppingButton = document.getElementById('shoppingButton');
		shoppingButton.innerText = "Обновить заказ";
		shoppingButton.style.backgroundColor = 'blue';
		document.getElementById('order').action = "shopping_cart.php";
		
	}
	function deleteItem(idItem, value)
	{
		var tr = document.getElementById(idItem);
		var item = document.getElementById(value);
		item.disabled = "true";
		tr.style.display = "none";
		tr.innerHTML += "<input class='hidden' type='text' name='" + idItem + "' value='" + value + "'>";
		changeShoppingButton();
	}
</script>