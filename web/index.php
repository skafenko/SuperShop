<?php

include_once("php/start.php");

include_once("php/variables.php");

include_once("php/functions.php");

if(isset($_POST['adminLogOut']))
{
	session_unset();
}

if(isset($_POST['logOut']))
{
	if (!empty($_SESSION['cart']))
	{
		saveCart($_SESSION['idUser']);
	}
	else
	{
		deleteCart($_SESSION['idUser']);
	}
	
	session_unset();
}


//--------------------------------------------------------get array promo items--------------------------------------------
$arrayAllPromo = getItemsByTrue('promo');

$fourPromoItems = array_rand($arrayAllPromo, 4);

//--------------------------------------------------------get array new items--------------------------------------------

$arrayAllNew = getNewItems();

//--------------------------------------------------------get array popular items--------------------------------------------
$resultArray = getItemsByTrue('popular');

//-------------------------------------------------------load background image---------------------------------
$indexPromoItem = $fourPromoItems[0];
$promoCategory = $arrayAllPromo[$indexPromoItem]['category'];
loadBackgroundImate($promoCategory);



?>
<!doctype html>
<html>
<head>
	<title>Home</title>
<link rel="stylesheet" href="css/importFonts.css" type="text/css">
<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/index.css" type="text/css">

	<link rel="stylesheet" href="css/fourProduct.css" type="text/css">
     <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

  <link rel="stylesheet" href="js/owlCarousel/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="js/owlCarousel/owl-carousel/owl.theme.css">
<script src="js/owlCarousel/owl-carousel/owl.carousel.js"></script>
<script>
$(document).ready(function() {
 var owl = $("#things1");
var owl2 = $("#things");
 owl.owlCarousel({
  items: 4,
  slideBy: 4,
  loop:false,

  slideSpeed : 1000,
  
   
  nav: true,
  navText: false,
  autoWidth: true,
  margin:0,
padding:0,
pagination : false 
 });

owl2.owlCarousel({
  items: 4,
  slideBy: 4,
  loop:false,

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

$("#Goods #newGoods .second").click(function(){
    owl2.trigger('owl.next');
owl2.trigger('owl.next');
  });
  $("#Goods #newGoods .first").click(function(){
    owl2.trigger('owl.prev');
owl2.trigger('owl.prev');
  });
$("#Goods #newGoods .first").hover(function () {
    $(this).addClass('sprite-arrowLeftHover');
    $(this).removeClass('sprite-arrowLeft');
}, function () {
    $(this).removeClass('sprite-arrowLeftHover');
    $(this).addClass('sprite-arrowLeft');
});

$("#Goods #newGoods .second").hover(function () {
    $(this).addClass('sprite-arrowRightHover');
    $(this).removeClass('sprite-arrowRight');
}, function () {
    $(this).removeClass('sprite-arrowRightHover');
    $(this).addClass('sprite-arrowRight');
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
</head>
<body>
	<div id="wrapper" style="background: url(<?php echo $srcBackgroundImage; ?>) 100% 100% no-repeat;background-size: 100% 100%;">

		<?php include("pages/header.php"); ?>
		
			<form id="offer" action="product.php" method="POST">
			<?php
			
			echo "<div class='name'>".$arrayAllPromo[$indexPromoItem]['nameitem']."</div>
					<div class='inf'>".$arrayAllPromo[$indexPromoItem]['info']."</div>
					<input type='text' name='idItem' class='hidden' value='".$arrayAllPromo[$indexPromoItem]['id']."'>"	
			?>
			<div id="look"><a href="#" onClick="document.getElementById('offer').submit();">Посмотреть +</a></div>
		</form>
		
		<div id="superShop">SUPER SHOP</div>
   	</div>
	<div id="Goods">
		<div id="newGoods">
			<p>Новые товары</p>
			
<i class="sprite first sprite-arrowLeft"></i>
			<i class="sprite second sprite-arrowRight"></i>
		</div>
		<div id="things">
		<?php
		$amountOfNewItems = 0;
$count = 0;
		foreach ($arrayAllNew as $array)
		{
			$amountOfNewItems++;
			$idNewItems = $array['id'];
			$priceNewItem = 0;
			$oldPriceNewItem = "";
			$category = $array['category'];
			$displayNone = "";
			/*if ($amountOfNewItems > 8)
			{
				$displayNone = "style='display:none;'";
			}*/
			foreach ($array as $key => $value)
			{
				if ($key != '0')
				{
					if ($key == 'price') $priceNewItem = $value;
					if ($key == 'oldprice' && $priceNewItem < $value) $oldPriceNewItem = $value." ".$currency;
				}
			}
if ($count == 0) echo "<div class='prod floatLeft' height=652>";
				echo "<form method='POST' name='".$amountOfNewItems."' action='product.php' class='floatLeft product_price' onClick='showItem(".$amountOfNewItems.")'                           id='".$amountOfNewItems."' ".$displayNone.">
							<div class='wrap'>
								 <div class='image'><img src='".$items."/".$category."/".$idNewItems."/1.jpg' alt='".$category."-".$idNewItems."' height='240'></div>
								 <div class='namePrice'>
									<p class='floatLeft'>".$array['nameitem']."</p> 
									<em>".$priceNewItem." ".$currency."</em>
									<span>".$oldPriceNewItem."</span>
								</div>
							 </div>
							 <input type='text' name='idItem' class='hidden' value='".$idNewItems."'>
						</form>";
$count++;
if ($count == 2) 
{
echo "</div>";
$count = 0;
}
			
		}
if ($count == 1) echo "</div>";
echo "</div>";
		echo "<div id='amountNewItems' style='display:none;'>".$amountOfNewItems."</div>";
		?>
		
	</div>
	<div id="banners">
		
		<form action="product.php" method="POST" class="floatLeft" id="layer4" onClick="this.submit();">
			<img src="images/layer4.jpg" alt="layer4">
			<?php showPromoItem(1) ?>
			
		</form>
		<form action="product.php" method="POST" class="floatLeft" id="layer5" onClick="this.submit();">
			<img src="images/layer5.jpg" alt="layer5">	
			<?php showPromoItem(2) ?>
		</form>
		<form action="product.php" method="POST" class="floatLeft" id="layer6" onClick="this.submit();">
			<img src="images/layer6.jpg" alt="layer6">
			<?php showPromoItem(3) ?>
		</form>
	</div>
	<div id="PGoods">
		<div id="newGoods" class="customNavigation">
			<p>Популярные товары</p>
			<i class="sprite first sprite-arrowLeft"></i>
			<i class="sprite second sprite-arrowRight"></i>
		</div>
		<div id="things1">
			<?php
			include("php/fourProduct.php");
echo "</div>";
			echo "<div id='amountPopularItems' style='display:none;'>".$amountOfPopularItems."</div>";
		?>
		
	</div>
	<div id="info">
		<div id="about">
			<p>О магазине</p>
			Наш Магазин "SuperShop" – это динамично развивающаяся компания, специализирующаяся на продаже товаров для спорта,
			активного отдыха и туризма от ведущих российских и зарубежных производителей.<br><br>
			Являясь официальным дилером а также региональным представителем большинства из них, «SuperShop» более 15 лет, 
			активно продвигает на российский рынок продукцию мировых брендов. В магазине "SuperShop", большой выбор сноубордов
			и вейкбордов, самокатов и роликов ведущих компаний США, Канады, Европы и Китая.
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
	<script type="text/javascript" src="js/fourProduct.js"></script>
</body>
</html>