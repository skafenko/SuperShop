<?php

include_once("php/start.php");

include_once("php/variables.php");

include_once("php/functions.php");

$amountOfNewItems = 0;	//just for working arrows



if (isset($_POST['idItem']))
{
	$_SESSION['idItem'] = $_POST['idItem'];
	$_SESSION['category'] = categoryById($_SESSION['idItem']);
	$categoryConvert = convertString("UTF-8", "UTF-8", $_SESSION['category']);
	
	$pathToFolderWithImage = $items."/".$categoryConvert."/".$_POST['idItem'];
	
	$srcImage = $items."/".$_SESSION['category']."/".$_POST['idItem'];
	
	
	$array = getItemsById($_SESSION['idItem']);
	
	
	if ($array[0]['label'] != "no" ) 
		$tag = "<img src='images/".$array[0]['label'].".png' alt='".$array[0]['label']."'>";
	
	$arraySrc = scandir($pathToFolderWithImage);
	
	$variantsMassive = preg_split("/[\s;]+/", $array[0]['variants']);

	$variation1 = isset($variantsMassive[0]) && $variantsMassive[0] != "" ? "<option>".$variantsMassive[0]."</option>" : "";
	$variation2 = isset($variantsMassive[1]) && $variantsMassive[1] != "" ? "<option>".$variantsMassive[1]."</option>" : "";
	$variation3 = isset($variantsMassive[2]) && $variantsMassive[2] != "" ? "<option>".$variantsMassive[2]."</option>" : "";
	if ($variation1 != "")
	{
		$variants = "<form id='variants' name='variants' action='".$actionForForm."' method='POST' ><label>Выберите вариант:
						<select name='variant' id='variant_select'>
							".$variation1."<br>
							".$variation2."<br>
							".$variation3."<br>
						</select>
					</label></form>";
	}
	if ($array[0]['oldprice'] > $array[0]['price'])
	{
		$oldPrice = $array[0]['oldprice']." ".$currency;
	}
	
	//--------------------------------------------------------get array items from category--------------------------------------------
	$resultArray = getItems($_SESSION['category']);
}
else
{
	echo "ERROR not set category and idItem";
	exit(0);
}

?>
<!doctype html>
<html>
<head>
	<title>Product</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/product.css" type="text/css">

	<link rel="stylesheet" href="css/fourProduct.css" type="text/css">
	<!--<link rel="stylesheet" href="js/alertify/themes/alertify.core.css" />
	<link rel="stylesheet" href="js/alertify/themes/alertify.default.css" id="toggleCSS" />-->
</head>
<body>
	<?php include("pages/header.php"); ?>
	
	<p><?php echo $_SESSION['category']; ?><br>
		
	</p>
	<form action="category.php" method="POST" id="formToCategory" onClick="this.submit();"><input name="category" id="category" class="hidden" value="<?php echo $_SESSION['category']; ?>">Вернуться в каталог</form>
	<div id="good">
		<div id="inner">
			<div id="picture">
				<div id="image">
					<?php echo $tag; ?>
					<img id='basicImage' src='<?php echo $srcImage."/1.jpg"; ?>' alt='1' height='470px' width='470px'>
				</div>
				<div id="images">
					<div id="wrap">
						<div class="arrowLeft floatLeft" onClick="changeImageByArrow('left');"></div>
						<?php 
							$maxId = 0;
							for ($i = 2, $id = -1; $i < count($arraySrc); $i++, $id--)
							{
								echo "<div><div id='".$id."_1'><img id='".$id."' onClick='changeImage(".$id.");' src='".$srcImage."/".$arraySrc[$i]."' alt='".$srcImage."/".$arraySrc[$i]."' width='56px' height='56px'></div></div>";
								$maxId--;
							} 
							echo "<div id='maxId' class='hidden'>".$maxId."</div>";
						?>
						<div class="arrowRight" onClick="changeImageByArrow('right');"></div>
						<div class="clear"></div>
					</div>
				</div>
			</div>

			<div id="buy"> 
				<div id="buyNow">
					<div>
						<span><?php echo $oldPrice; ?></span>
						<p><?php echo $array[0]['price']." ".$currency; ?></p>
						<div>
							<img src="images/iconHave.png" alt="iconHave">
							<span>есть в наличии</span>
						</div>
					</div>
					<form method="POST" name="buy" id='buyMe' action="<?php echo $actionForForm ?>" onClick="<?php echo $onClickBuyBotton; ?>">
						<div id="cartIcon2">
							<img src="images/cartIcon2.png" alt="cartIcon2" >
							<span>купить</span>
						</div>
					</form>
				</div>
				<div class="icons">
					<div>
						<img class="floatLeft" src="images/stroke.png" alt="stroke">
						<span>Бесплатная доставка</span><br>
							по всей России
					</div>
				</div>
				<div>
					<div class="icons">
						<img class="floatLeft" src="images/stroke2.png" alt="stroke2">
						<span>Горячая линия</span><br>
						8 800 000-00-00
					</div>	
				</div>
				<div>
					<div class="icons">
						<img class="floatLeft" src="images/stroke3.png" alt="stroke3">
						<span>Подарки</span><br>
						каждому покупателю
					</div>
				</div>
			</div>
			<div id="name"> 
				<div><?php  echo $array[0]['nameitem']; ?></div>
				<div id="dopInfa"><?php echo $array[0]['info']; ?><br>
					<?php echo $variants; ?>
				</div>
			
			</div>

			
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="PGoods">
		<div id="newGoods">
			<p>Другие товары из категории «<?php echo $_SESSION['category']; ?>»</p>
			<i class="sprite first sprite-arrowLeft"></i>
			<i class="sprite second sprite-arrowRight"></i>
		</div>
		<div id="things1">
			<?php
			include("php/fourProduct.php");
			echo "<div id='amountNewItems' style='display:none;'>".$amountOfPopularItems."</div>";
			echo "<div id='amountPopularItems' style='display:none;'>0</div>";
		?>						
		</div>
	<footer>
		<ul class="floatLeft">
			<li>Шаблон для экзаменационного задания.</li>
			<li>Разработан специально для «Всероссийской Школы Программирования»</li>
			<li>http://bedev.ru/</li>
		</ul>
		<a href="#">Наверх</a>
	</footer>
	
	<script type="text/javascript" src="js/product.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<!--<script src="js/alertify/lib/alertify.min.js"></script>-->
<script type="text/javascript" src="js/fourProduct.js"></script>


  <link rel="stylesheet" href="js/owlCarousel/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="js/owlCarousel/owl-carousel/owl.theme.css">
<script src="js/owlCarousel/owl-carousel/owl.carousel.js"></script>
<script>
$(document).ready(function() {
 var owl = $("#things1");
 owl.owlCarousel({
  items: 4,
  slideBy: 4,
  loop:true,

  slideSpeed : 1000,
  
   
  nav: true,
  navText: false,
  autoWidth: true,
  margin:0,
padding:0,
pagination : false 
 });

// Custom Navigation Events
    $("#PGoods #newGoods .second").click(function(){
    owl.trigger('owl.next');
owl.trigger('owl.next');
owl.trigger('owl.next');
owl.trigger('owl.next');
  });


  $("#PGoods #newGoods .first").click(function(){
    owl.trigger('owl.prev');
owl.trigger('owl.prev');
owl.trigger('owl.prev');
owl.trigger('owl.prev');
  });

$("#PGoods #newGoods .second").hover(function () {
    $(this).addClass('sprite-arrowRightHover');
    $(this).removeClass('sprite-arrowRight');
}, function () {
    $(this).removeClass('sprite-arrowRightHover');
    $(this).addClass('sprite-arrowRight');
});
$("#PGoods #newGoods .first").hover(function () {
    $(this).addClass('sprite-arrowLeftHover');
    $(this).removeClass('sprite-arrowLeft');
}, function () {
    $(this).removeClass('sprite-arrowLeftHover');
    $(this).addClass('sprite-arrowLeft');
});

 
});
</script>
</body>
</html>	