<?php

include("variables.php");

include("functions.php");


$status = $_POST['status'];
$idOrder = $_POST['idOrder'];

changeOrderStatusById($idOrder, $status);

?>