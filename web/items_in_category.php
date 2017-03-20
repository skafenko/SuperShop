<?php
include_once("php/start.php");

include_once("php/admin_control.php");

include_once("php/variables.php");


mb_internal_encoding("UTF-8");

include_once("php/functions.php");

if (isset($_POST['nameFolder']))
{
	$_SESSION['adminFolder'] = $_POST['nameFolder'];
}

if ($_SESSION['adminFolder'] == null)
{
	echo "<h1>Error: Папки не существует!</h1>";
	exit(0);
}

//---------------------------------------------------------------------------------------rename folderName-----------------------------
if (isset($_POST['rename']))
{	
	$newNameFolder = trim($_POST['newName']);
	renameFolder($newNameFolder);
}
//----------------------------------------------------------------------------------save background image---------------------------------
if (isset($_FILES['loadBackgroundImg']))
{
	$file = "loadBackgroundImg";
	loadPhoto($file, $_SESSION['adminFolder']);
}

//----------------------------------------------------------------------------------load background image---------------------------------
loadBackgroundImate($_SESSION['adminFolder']);

//------------------------------------------------------------------------------------change opicanie category-----------------------
if (isset($_POST['opicanieCategory']))
{
	changeOpicanie($_POST['opicanieCategory']);
}
//------------------------------------------------------------------------------------get opicanie category-----------------------
$arrayOpicanie = getOpicanie($_SESSION['adminFolder']);
$opicanieCategory = $arrayOpicanie[0]['opicanie'];
//--------------------------------------------------------------------------------delete item------------------------------------------
if (isset($_POST['deleteItem']))
{
	deleteItemFromDB();
	$nameFolderConv = convertString("UTF-8", "CP1251", $_SESSION['adminFolder']);
	deleteFolderItem($items."/".$nameFolderConv."/".$_SESSION['admin_idItem']);
	$_SESSION['admin_idItem'] = 0;
}
//------------------------------------------------------------------------------------get arrayItems in category-----------------------
$arrayItems = getItems($_SESSION['adminFolder']);


?>
<!doctype html>
<html>
<head>
	<title>Items in Category</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/items_in_category.css" type="text/css">

	<link rel="stylesheet" href="js/alertify/themes/alertify.core.css" />
	<link rel="stylesheet" href="js/alertify/themes/alertify.default.css" id="toggleCSS" />
	<script>
		document.createElement('aside');
	</script>
</head>
<body>

	<div id="wrapper">
	
			<?php include("php/admin_aside.php"); ?>

			<div id="content">
				<h1>Товары</h1>
				<form action="" id="renameFolder" name="renameFolder" method="POST">
					Текущая категория:<input type="text" name="newName" id="newName" value="<?php echo $_SESSION['adminFolder']; ?>">
					<input type="submit" name="rename" value="переименовать">
				</form>
				<form action="" id="categoryInf" name="categoryInf" method="POST" enctype="multipart/form-data">
					<div style="background: url(<?php echo $srcBackgroundImage; ?>) 100% 100% no-repeat;background-size: 738px 325px;">
						<?php echo "<br><p>ОПИСАНИЕ КАТЕГОРИИ <br><span id='opicanieCategory'> ".$opicanieCategory." </span></p>";  ?>	
						
					</div>
					<input type="text" name="opicanieCategory" id="opicanie" class="hidden" value="<?php echo $opicanieCategory; ?>"></input>
					<input type="file" name="loadBackgroundImg" id="loadBackgroundImg">
							<label class='change' id='labelBackgrpoundImage' for='loadBackgroundImg'>Изменить картинку</label>
					<span class="change" id="prompt">Изменить описание</span>
				</form>
				<table>
					<tr>
						<th>Название товара</th>
						<th>стоимость</th>
						<th></th>
					</tr>
					<?php
					
						for ($i = 0; $i < count($arrayItems); $i++)
						{
							if ($arrayItems == null)
								continue;
							echo "<tr><td>";
							echo  $arrayItems[$i]['nameitem'];
							echo "</td>";
							echo "<td>".$arrayItems[$i]['price']." руб.</td>";
							echo "<td><form action='item_information.php' name='lookItem' id='lookItem' method='POST'>";
							echo "<input type='text' name='idItem' id='idItem' value='".$arrayItems[$i]['id']."'>";
							echo "<input type='submit' name='look' value='просмотр'>";
							echo "</form>";
							echo "</td></tr>"; 
						}
					?>
				</table>
				<div class="clear"></div>
				<form action="item_information.php" method="POST" name="addItemInCategory">
				<input type="submit" name="addItem" value="Добавить товар">
				</form>
			</div>
	</div>
	
	<script src="http://code.jquery.com/jquery-1.9.1.js" charset="UTF-8"></script>
	<script src="js/alertify/lib/alertify.min.js" charset="UTF-8"></script>
	<script src="js/items_in_category.js" charset="UTF-8"></script>
	
</body>
</html>