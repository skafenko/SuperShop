
<link rel="stylesheet" href="css/admin_aside.css" type="text/css">
<script>
		document.createElement('aside');
</script>
<aside>
	<div id="top">
		SUPER<br>
		<span>SHOP</span>
	</div>
	<div id="navigate">
		<a href="orders.php"><div class="navigate" id="orders">Заказы</div></a>
		<a href="users.php"><div class="navigate" id="users">Пользователи</div></a>
		<a href="items.php"><div class="navigate" id="goods">Товары</div></a>
		<!--<div class="navigate" id="category">Категории</div>-->
	</div>
	<div id="user">
			admin@mail.ru<br>
			<form action="index.php" method="POST" name="admin_logout" onClick="this.submit();">
			<input class="hidden" name="adminLogOut" id="logOut">
				выйти
			</form>
	</div>
</aside>
