<?php

include_once("start.php");

include_once("variables.php");

include_once("functions.php");


$db_connect = db_connect();
unset($_SESSION['copyCart'][$_POST['indexCart']]);
$cartResult = implodeToBd($_SESSION['copyCart']);


if(strcmp("{}" , str_replace("'", "", $cartResult)) == 0)
{
	echo "Заказ №".$_POST['idOrder']." yдален!";
	deleteOrderById($_POST['idOrder']);
	exit();
}
pg_query($db_connect, "update ".$orders." set cart = ".$cartResult." where id= '".$_POST['idOrder']."';");
pg_close($db_connect);

?>