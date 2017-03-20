<?php
include_once("php/start.php");

include_once("php/admin_control.php");

include_once("php/variables.php");


include_once("php/functions.php");


if (isset($_POST['look']))
{
	$_SESSION['admin_idItem'] = $_POST['idItem'];
}
else if (isset($_POST['addItem']))
{
	$_SESSION['admin_idItem'] = "0";
}

//----------------------------------------------------create table of items if not exists--------------------------------------
createTableItems();


//--------------------------------------------------------------------look item-------------------------------------------------------
if (isset($_POST['look']))	
{
	//receive all items in current category
	$allItems = getItemsById($_SESSION['admin_idItem']);
	foreach($allItems as $a)
	{
		if (is_array($a))
		{ 
			$nameItem = $a['nameitem'];
			$itemsInfo = $a['info'];
			$variants = $a['variants'];
			$priceItem = $a['price'];
			$label = $a['label'];
			$promo = $a['promo'];
			$popular = $a['popular'];
			
			$variantsMassive = preg_split("/[\s;]+/", $variants);
			print_r($variantsMassive);
			$variation1 = checkVariation(0, $variantsMassive);
			$variation2 = checkVariation(1, $variantsMassive);
			$variation3 = checkVariation(2, $variantsMassive);
			
			echo $variation3;
		}
	}
}	
$idItem = $_SESSION['admin_idItem'];

//---------------------------------------------------------------------save item------------------------------------------------
if (isset($_POST['save']))
{
	$nameItem = trim($_POST['name']);
	$nameItemEmpty = checkCorrectField($nameItem);
	
	$itemsInfo = trim($_POST['itemsInfo']);
	$itemsInfoEmpty = checkCorrectField($itemsInfo);
	
	$priceItem = trim($_POST['price']);
	$priceItemEmpty = checkIsNumeric($priceItem);
	
	$label = $_POST['label'];
	
	$promo = $_POST['promo'];
	checkPromo($promo);
	
	$popular = $_POST['popular'];
	
	$havePhoto = $_POST['deletePhoto1'];
	
	deletePhoto($_POST['deletePhoto1']);
	deletePhoto($_POST['deletePhoto2']);
	deletePhoto($_POST['deletePhoto3']);
	deletePhoto($_POST['deletePhoto4']);
	
	$variation1 = trim($_POST['variation1']);
	$variation2 = trim($_POST['variation2']);
	$variation3 = trim($_POST['variation3']);
	
	$variants = $variation1.";".$variation2.";".$variation3;
	
	if (!$nameItem == "" && !$itemsInfo == "" && !$priceItem == "" && $havePromoItem == "" && !$havePhoto == "")
	{
		if ($idItem == "0")
		{
			addNewItem();
		}
		else
		{
			saveItem();										
		}
		
		loadPhoto2("file1");
		loadPhoto2("file2");
		loadPhoto2("file3");
		loadPhoto2("file4");	
	}
}

//-------------------------------------------------------------variation correct view-------------------------------
if ($variation2 == "")
{
	$variation2 = $variation3;
	$variation3 = "";
}
if ($variation1 == "")
{
	$variation1 = $variation2;
	$variation2 = "";
}	

//-----------------------------------------------------------------load photo------------------------------------------------------
loadPhotoForItem($_SESSION['admin_idItem']);

?>
<!doctype html>
<html>
<head>
	<title>Items information</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/item_information.css" type="text/css">

	<script>
		document.createElement('aside');	
		function imageForDelete(photo, deletePhoto)
		{
			var element = document.getElementById(photo)
			if (element != null)
			{
				document.getElementById(deletePhoto).value = element.alt;
			}
		}
		
		function deletImage(image, label, delet, file, photo, deletePhoto)
		{
			imageForDelete(photo, deletePhoto);
			
			document.getElementById(image).innerHTML = "не загружено";
			var lab = document.getElementById(label);
			lab.innerHTML = "Загрузить";
			lab.className = "load";
			document.getElementById(delet).style.display = "none";
			document.getElementById(file).value = "";
		}
		
		//function, which work with photo
		function handleFileSelect(evt,list,label,delet,photo,deletePhoto) 
		{
			var files = evt.target.files; // FileList object

			// Loop through the FileList and render image files as thumbnails.
			for (var i = 0, f; f = files[i]; i++) 
			{

				// Only process image files.
				if (!f.type.match('image.*')) 
				{
					continue;
				}

				var reader = new FileReader();

				// Closure to capture the file information.
				reader.onload = (function(theFile) 
				{
					return function(e) 
					{
						var lab = document.getElementById(label);
						if ("Загрузить" == lab.innerHTML)
						{
							document.getElementById('deletePhoto1').value = "true";
							lab.innerHTML = "Изменить";
							lab.className += " change";
							document.getElementById(delet).style.display = "inline-block";
						}
						else if (lab.innerHTML == "Изменить")
						{
							imageForDelete(photo,deletePhoto);
						}
						var span = document.getElementById(list);
						span.innerHTML = ['<img  src="', e.target.result,
											'" title="', escape(theFile.name), '" height="150px" width="150px"/>'].join('');
						
					};
				})(f);

				// Read in the image file as a data URL.
				reader.readAsDataURL(f);
			}
		}
	</script>
</head>
<body>

	<div id="wrapper">
	
			<?php include("php/admin_aside.php"); ?>
			
			<div id="content">
				<h1>Просмотр товара</h1>
				<form action="" id="item" method="POST" enctype="multipart/form-data">
					<legend id="itemInfo">
					<p>Информация о товаре <span><?php echo $adminInformation; ?></span></p>
						<legend id="name_info">
							<label for="name">Название товара:</label>
							<br>
							<input type="text" name="name" id="name" value="<?php echo $nameItem; ?>" placeholder="<?php echo $nameItemEmpty; ?>">
							<br>
							<label for="itemsInfo">Описание товара:</label><br>
							<textarea name="itemsInfo" id="itemsInfo" placeholder="<?php echo $itemsInfoEmpty; ?>"><?php echo $itemsInfo; ?></textarea>
							<label for="price">Цена товара:</label>
							<br>
							<input type="text" name="price" id="price" value="<?php echo $priceItem; ?>" placeholder="<?php echo $priceItemEmpty; ?>"><span> руб.</span>
						</legend>
						<legend id="label">
							<label>Бейджик:</label><br>
							<input type="radio" name="label" id="none" value="no" <?php if ($label == "no") echo "checked";?>>
							<label for="none" class="label">Отсутствует</label><br>
							<input type="radio" name="label" id="new" value="new" <?php if ($label == "new") echo "checked";?>>
							<label for="new" class="label">NEW</label><br>
							<input type="radio" name="label" id="hot" value="hot" <?php if ($label == "hot") echo "checked";?>>
							<label for="hot" class="label">HOT</label><br>
							<input type="radio" name="label" id="sale" value="sale" <?php if ($label == "sale") echo "checked";?>>
							<label for="sale" class="label">SALE</label><br><br>
							
							<label>Промо-товар: <span style="color:red;"><?php echo $havePromoItem; ?></span></label><br>
							<input type="radio" name="promo" id="promoY" value="true" onClick="promoTrue();"<?php if ($promo == "true") echo "checked";?>>
							<label for="promoY" class="label">Да</label>   
							<input type="radio" name="promo" id="promoN" value="false" onClick="promoFalse();" <?php if ($promo == "false") echo "checked";?>>
							<label for="promoN" class="label">Нет</label><br><br>
							
							<label>Популярный товар:</label><br>
							<input type="radio" name="popular" id="popularY" value="true" <?php if ($popular == "true") echo "checked";?>>
							<label for="popularY" class="label">Да</label>   
							<input type="radio" name="popular" id="popularN" value="false" <?php if ($popular == "false") echo "checked";?>>
							<label for="popularN" class="label">Нет</label><br><br>
						</legend>
						<div class="clear"></div>
					</legend>
					<legend id="images">
						<p>Фотографии товара <span style="color:red"><?php echo $needloadPhoto; ?></span></p>
						<div class="wrap" id="wrap1">
							<?php echo $image1;?>
						</div>
						<div class="wrap" id="wrap2">
							<?php echo $image2;?>
						</div>
						<div class="wrap" id="wrap3">
							<?php echo $image3;?>
						</div>
						<div class="wrap" id="wrap4">
							<?php echo $image4;?>
						</div>
						<div class="clear"></div>
					</legend>
					<legend id="options">
						<p>Вариации товара</p>
						<input type="text" name="variation1" id="variation1" value="<?php echo $variation1; ?>">
						<span  class="deleteVariant" onClick="document.getElementById('variation1').value = '';">Удалить</span><br>
						<input type="text" name="variation2" id="variation2" value="<?php echo $variation2; ?>">
						<span  class="deleteVariant" onClick="document.getElementById('variation2').value = '';">Удалить</span><br>
						<input type="text" name="variation3" id="variation3" value="<?php echo $variation3; ?>">
						<span  class="deleteVariant" onClick="document.getElementById('variation3').value = '';">Удалить</span><br>
					</legend>
					<input type="submit" name="save" value="Сохранить изменения">
				</form>
				<form action="items_in_category.php" method="POST">
				<input type="submit" name="deleteItem" value="Удалить товар">
				</form>
				<div class="clear"></div>
			</div>
	</div>
	<script>
	
	document.getElementById('file1').addEventListener('change', function(e){handleFileSelect(e,'image1','label1','delete1', 'photo1', 'deletePhoto1')}, false);
	document.getElementById('file2').addEventListener('change', function(e){handleFileSelect(e,'image2','label2','delete2', 'photo2', 'deletePhoto2')}, false);
	document.getElementById('file3').addEventListener('change', function(e){handleFileSelect(e,'image3','label3','delete3', 'photo3', 'deletePhoto3')}, false);
	document.getElementById('file4').addEventListener('change', function(e){handleFileSelect(e,'image4','label4','delete4', 'photo4', 'deletePhoto4')}, false);
	
	if (document.getElementById('promoY').checked == true)
	{
		promoTrue();
	}
	function promoTrue()
	{
		document.getElementById('none').checked = true;
		disabled(true);
	}
	
	function promoFalse()
	{
		disabled(false);
	}
	
	function disabled(paremeter)
	{
		document.getElementById('new').disabled = paremeter;
		document.getElementById('hot').disabled = paremeter;
		document.getElementById('sale').disabled = paremeter;
	}
	
	</script>
</body>
</html>