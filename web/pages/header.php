<?php

include("php/shopping_cart_table.php");

$amountItemsInCart = getAmountItemsInCart();
//--------------------------------------------------------get array category--------------------------------------------
$allCategory = getCategoriesWithItems();


$cart = "<div class='floatLeft'>
			<p class='suma'>".$symma."<span> ".$currency."</span></p><br>
			<p class='object'>".$amountItemsInCart." предмета</p>
		</div>		
		<img src='images/cartIcon.png' alt='cartIcon' id='cartIcon'>";
$enter = "<div class='enter'>
					<img src='images/icon.png' alt='icon'>
					<a href='login.php' id='enter'>Войти</a>
					<a href='register.php'>Регистрация</a>
			</div>";
			
if (isset($_SESSION['idUser']))
{		
	$enter = "<div class='enter'>
					<a href='account.php' id='enter'>Кабинет</a>
					<form action='index.php' method='POST' onClick='this.submit();' name='logOut' id='logOut'>Выйти
					<input type='text' name='logOut' class='hidden'></form>
			</div>";
	
	
}
?>

<link type="text/css" rel="stylesheet" href="css/header.css">

<header>
			<a href="index.php" class="floatLeft">
				<div >SUPER<br>
					<span>SHOP</span>
				</div>
			</a>
			<div class="categoryMenu">
			<?php
			echo "<div class='categorys'>";
				foreach ($allCategory as $Array)
				{
					echo "<form class='floatLeft' action='category.php' method='POST'>
							<button name='category' type='submit' value='".$Array['category']."'>".$Array['category']."</button>
						</form>";
				}
				echo "</div>";
				
				echo $enter;
			?>	
				<div class="cart floatRight" onClick="window.open('shopping_cart.php', '_self');">
					<?php echo $cart; ?>	
				</div>
			</div>
			
</header>