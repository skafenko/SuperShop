<?php
if(!isset($_SESSION['adminMail']) && !isset($_SESSION['adminPassword']))
{
	include_once("index.php");
	exit();
}
?>