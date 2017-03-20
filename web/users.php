<?php

include_once("php/start.php");

include_once("php/admin_control.php");

include_once("php/variables.php");

include_once("php/functions.php");

if (isset($_POST['deleteUsera']) && isset($_SESSION['idUsera']))
{
	deleteUseraById($_SESSION['idUsera']);
	deleteOrdersByIdUsera($_SESSION['idUsera']);
	unset($_SESSION['idUsera']);
}
$arrayUsers = getUsers();


?>
<!doctype html>
<html>
<head>
	<title>Users</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/users.css" type="text/css">
	
</head>
<body>
	<div id="wrapper">
			<?php include("php/admin_aside.php"); ?>
			<div id="content">
				<h1>Пользователи</h1>
				<table>
					<tr>
						<th>Имя</th>
						<th>e-mail </th>
						<th>телефон</th>
						<th></th>
					</tr>
					<?php
					
						for ($i = 0; $i < count($arrayUsers); $i++)
						{
							if ($arrayUsers == null)
								continue;
							echo "<tr>";
							echo "<td>".$arrayUsers[$i]['fio']."</td>";
							echo "<td>".$arrayUsers[$i]['mail']."</td>";
							echo "<td>".$arrayUsers[$i]['phone']."</td>";
							echo "<td><form action='user_information.php' name='lookUser' id='lookUser' method='POST'>
												<input type='text' name='idUsera' id='idUsera' value='".$arrayUsers[$i]['id']."'>
												<input type='submit' name='look' value='просмотр'>
											</form></td>";
						}
					?>
				</table>
				<div class="clear"></div>
			</div>
	</div>
</body>
</html>