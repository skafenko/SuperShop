<?php
//------------------------------------------------------------------------admin information
$adminMail = "admin@mail.ru";
$adminPassword = "Admin1";
//-----------------------------------------------------------------------Postgres connect
$host = "postgres56.1gb.ru";
$port = "5432";
$dbname = "xgb_x_super344";
$user = "xgb_x_super344";
$password = "zce33ab2wr";

//-----------------------------------------------------------------------tables in db
$items = "items";
$categories = "categories";
$users = "users";
$orders = "orders";


//-------------------------------------------------------------------------categories
$opicanieCategory = "Описание катерогии";

//--------------------------------------------------------------------------------items_in_categories
$srcBackgroundImage = "images/bg.jpg";//index, category


//--------------------------------------------------------------------------------item_information
$nameItem = "";
$itemsInfo = "";
$priceItem = "";
$label = "no";
$promo = "false";
$havePromoItem = "";
$popular = "false";
$nameItemEmpty = "";
$itemsInfoEmpty = "";
$priceItemEmpty = "";
$image1 = "";
$image2 = "";
$image3 = "";
$image4 = "";
$deleteImage1 = "";
$deleteImage2 = "";
$deleteImage3 = "";
$deleteImage4 = "";
$needloadPhoto = "";
$variation1 = "";
$variation2 = "";
$variation3 = "";
$variants = "";
$adminInformation = "";



//--------------------------------------------------------------------------------category
$amountItems = 0;
$pages = 0;
$amountItemsOnSiteFirstPage = 17;
$amountItemsOnSiteAnotherPage = 20;

//--------------------------------------------------------------------------------product
//$onClickBuyBotton = "login('buyMe');";
//$actionForForm = "login.php";
$onClickBuyBotton = "buyItem('buyMe');";
$actionForForm = "shopping_cart.php";
$tag = "";//shopping_cart
$oldPrice = "";


//--------------------------------------------------------------------------------shopping_cart
$variantForCart = "";
$display = "";
$arrayTable = null;


//--------------------------------------------------------------------------------checkout
$fio = "";
$phone = "";
$mail = "";
$yourMail = "";
$step1 = "";
$step2 = "hidden";
$step3 = "hidden";
$placeholderMail = "name@mail.ru";
$checked1 = "checked";
$checked2 = "";
$checked3 = "";
$tableCheck = "";
$symmaCheck = 0;

//--------------------------------------------------------------------------------account
$town = "";
$street = "";
$house = "";
$flat = "";
$mistakeMail = "";
$mistakeOldPassword = "";
$orderArray = array();
//--------------------------------------------------------------------------------orders
$classBlue = "blueText";
$classGray = "grayText";
$classPink = "pinkText";
$classYellow = "yellowText";
$classGreen = "greenText";
$class = $classBlue;

$currency = "руб.";
$symma = 0;
$amountItemsInCart = 0;
$status = "есть в наличии";


?>