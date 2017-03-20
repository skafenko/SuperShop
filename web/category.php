<?php

include("php/start.php");

include("php/variables.php");

include("php/functions.php");

if (isset($_POST['category']))
{
	$_SESSION['category'] = $_POST['category'];
	$categoryOur = $_POST['category'];
}
if (isset($_SESSION['category']))
{
	$categoryOur = $_SESSION['category'];
}

//----------------------------------------------------------------get opicanieCategory------------------------------
$opicanieCategory = getOpicanie($_SESSION['category']);

//--------------------------------------------------------get array all items from our category wihtout promo--------------------------------------------
if ($_SESSION['category'] !== null)
{
	$arrayAllItems = getItemsByCategoryAndPromo($categoryOur, 'false');
	
	
	$amountItems = count($arrayAllItems);
	if ($arrayAllItems[0] == "")
		$amountItems = 0;
	
	if ($amountItems > $amountItemsOnSiteFirstPage)
	{
		$pages++;
		$pages += ceil(($amountItems - $amountItemsOnSiteFirstPage) / $amountItemsOnSiteAnotherPage);
	}
	else
	{
		$pages++;
	}
	
//--------------------------------------------------------get  promo item--------------------------------------------
	$arrayPromo = getItemsByCategoryAndPromo($categoryOur, 'true');
}


//-------------------------------------------------------download backgroundImage----------------------------------------
loadBackgroundImate($categoryOur);

?>
<!doctype html>
<html>
<head>
	<title>Category</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/category.css" type="text/css">

</head>
<body>
	<?php include("pages/header.php"); ?>
	<p>
		<?php echo $categoryOur."<br><span class='hidden' id='amountItems'>".$amountItems."</span>" ?>
		<script> 
			var amountItems = parseInt(document.getElementById('amountItems').innerText);
			var rangeItemsFrom = 1;
			if (amountItems == 0)
				rangeItemsFrom = 0;
			var rangeItemsTo = 1;
			var amountItemsOnSite = 17;
			if (amountItems < amountItemsOnSite)
				rangeItemsTo = amountItems;
			else
				rangeItemsTo = amountItemsOnSite;
			
		</script>
		<span id="range">
			<script>
				document.write("Показано " + rangeItemsFrom + "-" + rangeItemsTo + " из " + amountItems + " товаров");
			</script>
		</span>
	</p>
	
	<div id="Goods">
        <div class="wrapUp">
			<div id="page">
				<div>Страницы 
					<?php
					
					for ($i = 1; $i <= $pages; $i++)
					{
						echo "<nav href='' onClick='nextPage(".$i.");'><span>".$i."</span></nav>";
					}
					?>
				</div>
			</div>
		</div>
		
		<div class='floatLeft info' id="0">
			<div style="background: url(<?php echo $srcBackgroundImage; ?>) 100% 100% no-repeat;background-size: 877px 325px;">
				<?php echo "<br><p>ОПИСАНИЕ КАТЕГОРИИ <br><span id='opicanieCategory'> ".$opicanieCategory[0]['opicanie']." </span></p>";  ?>			
			</div>	
		</div>
		<?php
		$amountOfItems = 0;
		foreach ($arrayAllItems as $array)
		{
			$amountOfItems++;
			$idNewItems = $array['id'];
			$nameNewItem = $array['nameitem'];
			$priceNewItem = $array['price'];
			$oldPriceNewItem = "";
			$category = $categoryOur;
			$displayNone = "";
			
			if ($amountOfItems > 17)
			{
				$displayNone = "style='display:none;'";
			}
			$label = "";
			foreach ($array as $key => $value)
			{
				if ($key != '0')
				{
					if ($key == 'oldprice' && $priceNewItem < $value) $oldPriceNewItem = $value." ".$currency;
					if ($key == 'label' && $value != 'no') $label = "<img src='images/".$value.".png' alt='".$value."'>";
				}
			}
				
			echo "<form method='POST' name='".$amountOfItems."' action='product.php' class='floatLeft product_price' onClick='showItem(".$amountOfItems.")' id='".$amountOfItems."' ".$displayNone.">
						<div class='wrap'>
							 <div class='image'>".$label."<img src='".$items."/".$category."/".$idNewItems."/1.jpg' alt='".$category."-".$idNewItems."' height='240px'></div>
							 <div class='namePrice'>
								<p class='floatLeft'>".$nameNewItem."</p> 
								<em>".$priceNewItem." ".$currency."</em>
								<span>".$oldPriceNewItem."</span>
							</div>
						 </div>
						 <input type='text' name='idItem' class='hidden' value='".$idNewItems."'>
					</form>";
			
			if ($arrayPromo[0] != "" && ($amountOfItems == 11 && $amountItems > 11 || 
					$amountItems <= 7 && $amountItems >= 3 && $amountOfItems == 3 || 
					$amountItems <= 11 && $amountItems > 7 && $amountOfItems == 7 || 
					$amountItems < 3 && $amountOfItems == $amountItems ||
					$amountItems == 0 && $amountOfItems == 0))
				{
					$promoItem = "promoItem";
					echo "<form method='POST' id='promoItem' name='promoItem' class='floatRight' action='product.php' onClick='this.submit();'>
						<div id='offer'>
							<div>".$arrayPromo[0]['nameitem']."<br><span>".$arrayPromo[0]['info']."</span></div>
							<p>".$arrayPromo[0]['price']." ".$currency."</p>
							<input type='text' name='idItem' class='hidden' value='".$arrayPromo[0]['id']."'>
							<div id='look' onClick='this.submit();'>Посмотреть +</div>
						</div>
					</form>";
				}
		}
		echo "<div id='amountNewItems' style='display:none;'>".$amountOfItems."</div>";
		?>
		
		<div id="hidden"></div>
		<div class="wrapUp">
			<div id="page">
				<div>Страницы 
					<?php
					for ($i = 1; $i <= $pages; $i++)
					{
						echo "<nav href='' onClick='nextPage(".$i.");'><span>".$i."</span></nav>";
					}
					?> 
				</div>
			</div>
		</div>
	</div>
	<footer>
		<ul class="floatLeft">
			<li>Шаблон для экзаменационного задания.</li>
			<li>Разработан специально для «Всероссийской Школы Программирования»</li>
			<li>http://bedev.ru/</li>
		</ul>
		<a href="#">Наверх</a>
	</footer>
	<script>
		
		function nextPage(page)
		{
			var spanRange = document.getElementById('range');
			amountItemsOnSiteFirstPage = 17;
			amountItemsOnSiteAnotherPage = 20;
			if (page == 1)
			{
				rangeItemsFrom = 1;
				rangeItemsTo = amountItems < amountItemsOnSiteFirstPage ? amountItems : amountItemsOnSiteFirstPage;
				document.getElementById('0').style.display='block';
				document.getElementById('promoItem').style.display='block';
				var displayNoneFrom = rangeItemsTo + 1;
				var displayNoneTo= amountItems;
				for ($i = displayNoneFrom; $i <= displayNoneTo; $i++)
				{
					document.getElementById($i).style.display='none';
				}
				for ($i = rangeItemsFrom; $i <= rangeItemsTo; $i++)
				{
					document.getElementById($i).style.display='block';
				}
			}
				
			else 
			{
				if (page == 2)
					rangeItemsFrom = 1 + amountItemsOnSiteFirstPage * (page - 1);
				else 
					rangeItemsFrom = amountItemsOnSiteFirstPage + 1 + amountItemsOnSiteAnotherPage * (page - 1) - amountItemsOnSiteAnotherPage;
				
				rangeItemsTo = amountItems < (amountItemsOnSiteAnotherPage * (page - 1) + amountItemsOnSiteFirstPage) ? amountItems : amountItemsOnSiteAnotherPage * (page - 1) + amountItemsOnSiteFirstPage;
				document.getElementById('0').style.display = "none";
				document.getElementById('promoItem').style.display='none';
				var displayNoneFrom = 1;
				var displayNoneTo= amountItems;
				for ($i = displayNoneFrom; $i <= displayNoneTo; $i++)
				{
					document.getElementById($i).style.display='none';
				}
				for ($i = rangeItemsFrom; $i <= rangeItemsTo; $i++)
				{
					document.getElementById($i).style.display='block';
				}
				
			}
				
			
			spanRange.innerText = ("Показано " + rangeItemsFrom + "-" + rangeItemsTo + " из " + amountItems + " товаров");
		}
		
		function showItem(id)
		{
			document.getElementById(id).submit();
		}
	</script>
</body>
</html>