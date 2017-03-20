<?php

include_once("php/start.php");

include_once("php/admin_control.php");

include_once("php/variables.php");

mb_internal_encoding("UTF-8");

include_once("php/functions.php");

//--------------------------------------------------------------------------create forder items----------------------------
if (!is_writable($items))	
{
  mkdir($items);
}
createTableItems();
//---------------------------------------------------------------------------create new Folder------------------------------
if (isset($_POST['add']))       
{
	$nameNewFolder = trim($_POST['nameCategory']);
	addFolder($nameNewFolder);
}
//-----------------------------------------------------------------------------delete folder--------------------------
else if (isset($_POST['delete']))       
{
	$name = $_POST['deleteNameFolder'];
	deleteFolder($name);
}

//-----------------------------------------------------------------------------all categories-----------------------------
$arrayCategories = getCategories();

?>
<!doctype html>
<html>
<head>
	<title>Items</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/items.css" type="text/css">

</head>
<body>
	<?php
	?>
	<div id="wrapper">
	
			<?php include("php/admin_aside.php"); ?>
			
			<div id="content">
				<h1>Категории</h1>
				<table>
					<tr>
						<th>Название категории </th>
						<th>количество товаров</th>
						<th></th>
					</tr>
					<?php
					
						for ($i = 0; $i < count($arrayCategories); $i++)
						{
							if ($arrayCategories == null)
								continue;
							echo "<tr>";
							echo "<td>".$arrayCategories[$i]['category']."</td>";
							echo "<td>".$arrayCategories[$i]['amount_items']."</td>";
							if ($arrayCategories[$i]['amount_items'] == 0) 
							{	
								echo "<td><form action='' name='deleteFolder' id='deleteFolder' method='POST'>
												<input type='text' name='deleteNameFolder' id='deleteNameFolder' value='".$arrayCategories[$i]['category']."'>
												<input type='submit' name='delete' value='удалить'>
											</form>
											<form action='items_in_category.php' name='lookFolder' id='lookFolder' method='POST'>
												<input type='text' name='nameFolder' id='nameFolder' value='".$arrayCategories[$i]['category']."'>
												<input type='submit' name='look' value='просмотр'>
											</form></td>"; 
							}
							else 
							{
								echo "<td><form action='items_in_category.php' name='lookFolder' id='lookFolder' method='POST'>
												<input type='text' name='nameFolder' id='nameFolder' value='".$arrayCategories[$i]['category']."'>
												<input type='submit' name='look' value='просмотр'>
											</form></td>";
							}
						}
					?>
				</table>
				<div class="clear"></div>
				<form action="" name="addFolder" id="addFolder" method="POST">
					Добавить категорию:<input type="text" name="nameCategory" id="nameCategory" placeholder="название категории"><br>
					<input type="submit" name="add" value="добавить категорию">
				</form>
			</div>
	</div>
	
</body>
</html>