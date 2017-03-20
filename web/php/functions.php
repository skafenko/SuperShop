<?php
//-----------------------------------------------------------------------basic------------------------------------------

function db_connect()
{
	global $host, $port, $dbname, $user, $password;
	$db_connect = pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password);
	return $db_connect;
}

function convertMassive($from, $to, $array)
{
	
	for ($i = 0; $i < count($array); $i++)
	{
		$array[$i] = iconv($from, $to, $array[$i]);
	}
	return $array;
}

function convertString($from, $to, $string)
{
	$string = iconv($from, $to, $string);
	return $string;
}
//---------------------------------------------------------------------admin items.php-------------------------------------------------
function addFolder($nameFolder)
{
	global $categories, $opicanieCategory, $items;
	
	$db_connect = db_connect();
	pg_query($db_connect, "create table if not exists ".$categories." (
                                 id serial,
								 category varchar UNIQUE,
								 amount_items int, 
								 opicanie varchar
								 );");
	
	pg_query($db_connect, "insert into ".$categories." (category, amount_items, opicanie) values 
                                             ('".$nameFolder."', '0', '".$opicanieCategory."' );");										 
											 
	pg_close($db_connect);
	
	$foldername = $items."/".$nameFolder;
	$foldername = convertString("UTF-8", "UTF-8", $foldername);
	if (!is_dir($foldername))
	{
		mkdir($foldername);
	}
}

function deleteFolder($nameFolder)
{
	//delete from bd
	global $categories, $items;
	$db_connect = db_connect();
	pg_query($db_connect, "delete from ".$categories." where category = '".$nameFolder."'");
	
	//delete from folder folder items
	pg_close($db_connect);
	$nameFolder = convertString("UTF-8", "UTF-8", $nameFolder);
	if (is_dir($items."/".$nameFolder))
		rmdir($items."/".$nameFolder);
	
	//delete backgroundImage category
	$nameFolder = str_replace(" ", "_", $nameFolder);
	if (file_exists("images/backgroundImage/".$nameFolder."_backgroundImage.jpg"))
	{
		unlink("images/backgroundImage/".$nameFolder."_backgroundImage.jpg");
	}
}

function getCategories()
{
	global $categories;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select category, amount_items from ".$categories);
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array;
}

//---------------------------------------------------------------------admin items_in_category.php-------------------------------------------------
function renameFolder($newName)
{
	global $categories, $items;
	$db_connect = db_connect();
	$newNameFolderConv = convertString("UTF-8", "UTF-8", $newName);
	$oldNameFolder = convertString("UTF-8", "UTF-8", $_SESSION['adminFolder']);
	
	if (!is_dir($items."/".$newNameFolderConv))
	{
		pg_query($db_connect, "update ".$categories." set category = '".$newName."' where category = '".$_SESSION['adminFolder']."';");
		rename($items."/".$oldNameFolder, $items."/".$newNameFolderConv);
		$_SESSION['adminFolder'] = $newName;
	}
	pg_close($db_connect);	
}

function loadPhoto($file, $nameFolder)
{
	if ($_FILES[$file]['name'] == "")
	{
		$_FILES[$file]['error'] = 0;
	}
	if ($_FILES[$file]['error'] == 0)
	{
		if ($_FILES[$file]['type'] == 'image/jpeg' || 
			$_FILES[$file]['type'] == 'image/png' ||
			$_FILES[$file]['type'] == 'image/gif' ||
			$_FILES[$file]['type'] == 'image/bmp' ||
			$_FILES[$file]['type'] == 'image/jpg'	 ||
			$_FILES[$file]['type'] == '')
			{
				if (!is_dir("images/backgroundImage"))
				{
					mkdir("images/backgroundImage");
				}
				$nameFolder = str_replace(" ", "_", $nameFolder);
				$namefolderconvert = convertString("UTF-8", "UTF-8", $nameFolder);
				$_FILES[$file]['name'] = $namefolderconvert ."_backgroundImage.jpg";
				move_uploaded_file($_FILES[$file]['tmp_name'], "images/backgroundImage/".$_FILES[$file]['name']);
			}
		else
		{
			echo "Не верный формат картинки. Допустимые: jpeg, png, gif, bmp, jpg";
			exit(0);
		}
	}
	else
	{
		print_r($_FILES);
		echo "Ошибка при передачи файла на сервер";
		exit(0);
	}
}

function getOpicanie($category)//category
{
	global $categories;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select opicanie from ".$categories." where category = '".$category."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	return $array;
}	

function changeOpicanie($opicanie)
{
	global $categories;
	$db_connect = db_connect();
	pg_query($db_connect, "update ".$categories." set opicanie = '".$opicanie."' where category = '".$_SESSION['adminFolder']."';");
	pg_close($db_connect);
}

function getItems($category)
{
	global $items;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select id, nameitem, price, oldprice, info, category from ".$items." where category = '".$category."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	return $array;
}

function deleteItemFromDB()
{
	global $items, $categories;
	$db_connect = db_connect();
	pg_query($db_connect, "delete from ".$items." where id = '".$_SESSION['admin_idItem']."'");
	pg_query($db_connect, "update ".$categories." set 
												amount_items = amount_items - 1
												where category = '".$_SESSION['adminFolder']."';");
	pg_close($db_connect);
}

function deleteFolderItem($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            deleteFolderItem(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}
//---------------------------------------------------------------------admin item_information.php-------------------------------------------------
function loadPhoto2($file)
{
	if ($_FILES[$file]['name'] == "")
	{
		$_FILES[$file]['error'] = 0;
	}
	if ($_FILES[$file]['error'] == 0)
	{
		if ($_FILES[$file]['type'] == 'image/jpeg' || 
			$_FILES[$file]['type'] == 'image/png' ||
			$_FILES[$file]['type'] == 'image/gif' ||
			$_FILES[$file]['type'] == 'image/bmp' ||
			$_FILES[$file]['type'] == 'image/jpg'	 ||
			$_FILES[$file]['type'] == '')
			{
				$nameFolder = convertString("UTF-8", "UTF-8", $_SESSION['adminFolder']);
				$idItem = $_SESSION['admin_idItem'];
				if (!is_dir("items/".$nameFolder."/".$idItem))
				{
					mkdir("items/".$nameFolder."/".$idItem);
				}
				if ($file == "file1")
				{
					$_FILES[$file]['name'] = "1.jpg";
				}
				move_uploaded_file($_FILES[$file]['tmp_name'], "items/".$nameFolder."/".$idItem."/".$_FILES[$file]['name']);
			}
		else
		{
			echo "Не верный формат картинки. Допустимые: jpeg, png, gif, bmp, jpg";
			exit(0);
		}
	}
	else
	{
		print_r($_FILES);
		echo "Ошибка при передачи файла на сервер";
		exit(0);
	}
}

function createTableItems()
{
	global $items;
	$db_connect = db_connect();
	pg_query($db_connect, "create table if not exists ".$items." (
                                 id serial,
								 nameitem varchar,
								 info varchar,
								 variants varchar,
								 price real,
								 oldprice real,
								 label varchar,
								 promo varchar,
								 popular varchar,
								 category varchar,
								 status varchar
								 );");
	pg_close($db_connect);	
}

function getItemsById($id)
{
	global $items;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select nameitem, info, variants, price, oldprice, label, promo, popular, category, status from ".$items." where id = '".$id."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	return $array;
}

function loadPhotoForItem($id)
{
	global $needloadPhoto, $items, $image1, $image2, $image3, $image4;
	$idItem = $id;
	$hiddenFolders = 2;
	$nameFolderConvert = convertString("UTF-8", "UTF-8", $_SESSION['adminFolder']);
	$allPhoto;
	
	if (is_dir($items."/".$nameFolderConvert."/".$idItem))
	{
		$allPhoto = scandir($items."/".$nameFolderConvert."/".$idItem);
		$hiddenFolders = count($allPhoto);
	}
	
	if ($hiddenFolders - 2 == 0 && isset($_POST['save']))
	{
		$needloadPhoto = " (Загрузите фото товара)";
	}
	
	for ($p = 1, $i = 2; $p < 5; $i++, $p++)
	{
		
		$onClick = 'deletImage("image'.$p.'","label'.$p.'","delete'.$p.'", "file'.$p.'", "photo'.$p.'", "deletePhoto'.$p.'")';
		if ($i >= $hiddenFolders || $hiddenFolders == 2)
		{
			$i = 10;
		}
		if (isset($allPhoto[$i]))
		{
			$photo = convertString("UTF-8", "UTF-8", $allPhoto[$i]);
			$haveImage = "<div class='image' id='image".$p."'><image id='photo".$p."' height='150px' width='150px' alt='".$allPhoto[$i]."' src='".$items."/".$_SESSION['adminFolder']."/".$idItem."/".$photo."'></image></div>
							<input style='display:none' type='text' name='deletePhoto".$p."' id='deletePhoto".$p."' value='true'>
							<input type='file' name='file".$p."' id='file".$p."'><label class='load change' id='label".$p."' for='file".$p."'>Изменить</label><br>
							<div class='delete' style='display:inline-block;' id='delete".$p."' onClick='".$onClick.";'>Удалить</div>";
		}
			
		$haventImage = "<div class='image' id='image".$p."'>не загружено</div>
							<input style='display:none' type='text' name='deletePhoto".$p."' id='deletePhoto".$p."'>
							<input type='file' name='file".$p."' id='file".$p."'><label class='load' id='label".$p."' for='file".$p."'>Загрузить</label><br>
							<div class='delete'  id='delete".$p."' onClick='".$onClick.";'>Удалить</div>";
		switch($i)
		{
			case 2:
				$image1 = $haveImage;
				break;
			case 3:
				$image2 = $haveImage;
				break;
			case 4:
				$image3 = $haveImage;
				break;
			case 5:
				$image4 = $haveImage;
				break;
			default:
				if($image1 == "")
				{
					$image1 = $haventImage;
				}	
				else if ($image2 == "")
				{
					$image2 = $haventImage;
				}	
				else if ($image3 == "")
				{
					$image3 = $haventImage;
				}
				else if ($image4 == "")
				{
					$image4 = $haventImage;
				}
		}
	}
}

function checkVariation($index, $array)
{
	if(isset($array[$index]))
		return $array[$index];
	
}
function checkCorrectField($field)
{
	if ($field == "")
	{
		return "не введено!";
	}
	return "";
}
function checkIsNumeric($field)
{
	if ($field == "")
	{
		return "не введено!";
	}
	else if (!is_numeric($field))
	{
		return "введите суму в цифрах!";
	}
	return "";
}

function checkPromo($promoLabel)
{
	global $items, $havePromoItem, $promo;
	$db_connect = db_connect();
	$result = pg_query($db_connect, "select id from ".$items." where promo = 'true' and
																	category = '".$_SESSION['adminFolder']."'");
	$promoItem = pg_fetch_all($result);
	
	if (!$promoItem[0]['id'] == "" && $promoLabel == "true" && $_SESSION['admin_idItem'] != $promoItem[0]['id'])
	{
		$havePromoItem = "<input type='text' style='display:none;' name='idItem' value='".$promoItem[0]['id']."'>
							<input type='submit' id='promoItem' name='look' value='(промо товар уже создан)'>";
		$promo = "false";
	}
	
	pg_close($db_connect);
}

function deletePhoto($delete)
{
	global $items;
	if ($delete != "")
	{
		$nameFolderConvert = convertString("UTF-8", "UTF-8", $_SESSION['adminFolder']);
		if (file_exists($items."/".$nameFolderConvert."/".$_SESSION['admin_idItem']."/".$delete))
			unlink($items."/".$nameFolderConvert."/".$_SESSION['admin_idItem']."/".$delete);
	}
}

function addNewItem()
{
	global $items, $nameItem, $itemsInfo, $variants, $label, $promo, $priceItem, $popular, $adminInformation, $categories, $status;
	$db_connect = db_connect();
	$id = pg_query($db_connect, "insert into ".$items." (nameitem, info, variants, price, oldprice, label, promo, popular, category, status) values 
                                             ('".$nameItem."', '".$itemsInfo."', '".$variants."', '".$priceItem."', '".$priceItem."', 
											 '".$label."', '".$promo."', '".$popular."', '".$_SESSION['adminFolder']."', '".$status."')returning id;");
	
	
	while ($row = pg_fetch_row($id)) 
	{
		$_SESSION['admin_idItem'] = $row[0];				
	}
	
	$adminInformation = "(Товар добавлен)";
	pg_query($db_connect, "update ".$categories." set 
												amount_items = amount_items + 1
												where category = '".$_SESSION['adminFolder']."';");
	pg_close($db_connect);	
}

function saveItem()
{
	global $items, $nameItem, $itemsInfo, $variants, $label, $promo, $priceItem, $popular, $adminInformation;
	$db_connect = db_connect();
	
	$resultPrice = pg_query($db_connect, "select price, oldprice from ".$items." where id = '".$_SESSION['admin_idItem']."'");
	$price = pg_fetch_all($resultPrice);
	$oldPrice;
	if ($price[0]['price'] > $priceItem)//check if work old price
	{
		$oldPrice = $price[0]['price'];
	}
	else if ($price[0]['price'] < $priceItem && $price[0]['oldprice'] < $priceItem) 
		$oldPrice = $priceItem;
	else 
		$oldPrice = $price[0]['oldprice'];
	$itemsInfo = str_replace("'", "`", $itemsInfo);
	$nameItem = str_replace("'", "`", $nameItem);
	pg_query($db_connect, "update ".$items." set 
												nameitem = '".$nameItem."',
												info = '".$itemsInfo."',
												variants = '".$variants."',
												price = '".$priceItem."',
												oldprice = '".$oldPrice."',
												label = '".$label."', 
												promo = '".$promo."',
												popular = '".$popular."' where id = '".$_SESSION['admin_idItem']."';");
														
	$adminInformation = "(Изменения сохранены)";	
	pg_close($db_connect);	
}


//---------------------------------------------------------------------index.php-------------------------------------------------
function getCategoriesWithItems()
{
	global $categories;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select category from ".$categories." where amount_items > 0");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array;
}
function getItemsByTrue($columm)
{
	global $items;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select id, nameitem, price, oldprice, info, category from ".$items." where ".$columm." = 'true'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array;
}
function getNewItems()
{
	global $items;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select id, nameitem, price, oldprice, category from ".$items." where label = 'new'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array;
}
function showPromoItem($index)
{
	global $fourPromoItems, $arrayAllPromo;
	echo "<span class='name'>".$arrayAllPromo[$fourPromoItems[$index]]['nameitem']."</span>
						<input type='text' name='idItem' class='hidden' value='".$arrayAllPromo[$fourPromoItems[$index]]['id']."'>";
}

function saveCart($idUser)
{
	global $users;
	$db_connect = db_connect();

	$cartToBd = implodeToBd($_SESSION['cart']);
	
	pg_query($db_connect, "update ".$users." set 
												cart = ".$cartToBd." where id = '".$idUser."';");

	
	pg_close($db_connect);
}
function deleteCart($idUser)
{
	global $users;
	$db_connect = db_connect();

	$empty = "";
	
	pg_query($db_connect, "update ".$users." set 
												cart = '{".$empty."}' where id = '".$idUser."';");

	
	pg_close($db_connect);
}
//---------------------------------------------------------------------category.php-------------------------------------------------

function getItemsByCategoryAndPromo($category, $promo)
{
	global $items;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select id, nameitem, info, price, oldprice, label from ".$items." where promo = '".$promo."' and category = '".$category."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	return $array;
}

function loadBackgroundImate($category)//items_in_category, index
{
	global $srcBackgroundImage;
	$folderReplace = str_replace(" ", "_", $category);

	$folderReplaceConv = convertString("UTF-8", "UTF-8",$folderReplace);

	if (file_exists("images/backgroundImage/".$folderReplaceConv."_backgroundImage.jpg"))
	{
		$srcBackgroundImage = "images/backgroundImage/".$folderReplace."_backgroundImage.jpg";
	}
}


//---------------------------------------------------------------------category.php-------------------------------------------------
function categoryById($id)
{
	global $items;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select category from ".$items." where id = '".$id."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	$category = $array[0]['category'];
	return $category;
}

//---------------------------------------------------------------------shoping_cart.php-------------------------------------------------
function checkIdInSession($id)
{
	if (isset($_SESSION['cart']))
	{
		$amountItemsInCart = count($_SESSION['cart']);
		$result = $amountItemsInCart;
		
		for ($i = 0; $i < $amountItemsInCart; $i++)
		{
			if ($_SESSION['cart'][$i]['idItem'] == $id)
			{
				if (checkVariant($i))
				{
					$result = $i;
					break;
				}
				
			}
		}
	}
	else
	{
		$amountItemsInCart = -1;
		$result = $amountItemsInCart;
	}
		
	
	return $result;
}
function addItemToCart($indexItem)
{
	if($indexItem == -1 || $indexItem == count($_SESSION['cart']))
	{
		if ($indexItem == -1)
			$indexItem = 0;
		$_SESSION['cart'][$indexItem]['idItem'] = $_SESSION['idItem'];
		$_SESSION['cart'][$indexItem]['amountItem'] = 1;
		if (isset($_POST['variant']))
		{
			$_SESSION['cart'][$indexItem]['variant'] = $_POST['variant'];
		}
	}
	else
	{
		if (checkVariant($indexItem))
			$_SESSION['cart'][$indexItem]['amountItem'] += 1;
		else
			addItemToCart(count($_SESSION['cart']));
	}
}

function checkVariant($indexItem)
{
	if (isset($_POST['variant']) && isset($_SESSION['cart'][$indexItem]['variant']) && $_POST['variant'] == $_SESSION['cart'][$indexItem]['variant'])
			return true;
	else if (!isset($_POST['variant']))
		return true;
	else
		return false;
}
function getAmountItemsInCart()
{
	$amount = 0;
	if(isset($_SESSION['cart']))
	{
		foreach($_SESSION['cart'] as $array)
		{
			$amount += $array['amountItem'];
		}
	}
	return $amount;
}

//---------------------------------------------------------------------checkout.php-------------------------------------------------
function checkMail($mail)//register
{
	global $users;
	createTableUsers();
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select id from ".$users." where mail = '".$mail."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	if (empty($array))
		return false;
	return true;

}
//---------------------------------------------------------------------checkout_4.php-------------------------------------------------
function createUser()
{
	createTableUsers();
	
	global $users;
	$db_connect = db_connect();
	$password = rand_passwd();
	$today = date("Y-m-d H:i");  
	if( empty($_SESSION['flat']))
		$_SESSION['flat'] = "";
	$id = pg_query($db_connect, "insert into ".$users." (fio, phone, mail, password, town, street, house, flat, date) values 
                                             ('".$_SESSION['fio']."', '".$_SESSION['phone']."', '".$_SESSION['mail']."', '".$password ."', 
											 '".$_SESSION['town']."', '".$_SESSION['street']."', '".$_SESSION['house']."', '".$_SESSION['flat']."', 
											 '".$today."')returning id;");
	
	$id = pg_fetch_row($id);
	
	pg_close($db_connect);
	$_SESSION['idUser'] =  $id[0];
}


function createOrder()
{
	createTableOrders();
	
	global $orders, $users;
	$db_connect = db_connect();
	$today = date("Y-m-d H:i");
	$status = "принят";
	$userId = $_SESSION['idUser'];
	$cartToBd = implodeToBd($_SESSION['cart']);
	
	$id = pg_query($db_connect, "insert into ".$orders." (userid, cart, status, town, street, house, flat, delivery, comment, date, symma) values 
										('".$userId."', ".$cartToBd.", '".$status."', '".$_SESSION['town']."', 
										'".$_SESSION['street']."', '".$_SESSION['house']."', '".$_SESSION['flat']."', '".$_SESSION['delivery']."', 
										'".$_SESSION['yourComment']."', '".$today."', '".$_SESSION['symma']."')returning id;");
	
	$id = pg_fetch_row($id);
	
	pg_close($db_connect);
	session_destroy();
	session_start();
	$_SESSION['idUser'] = $userId;
	$_SESSION['idOrder'] = $id[0];
}
function implodeToBd($array) {
	$result = "'{";
	$count = 0;
    foreach($array as $val)
	{
		$values = "";
		$values = implode(',', $val);
		if (count($val) == 2)
			$values = $values.",empty";
		if ($count == 0){
			$result = $result."{".$values."}";
			$count++;
		}
		else
			$result = $result.",{".$values."}";
		
	}
	$result = $result."}'";
	return $result;    
}
function rand_passwd() 
{
	$length = 8;
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr( str_shuffle( $chars ), 0, $length );
}
function getArrayCartFromBD($id, $table)
{
	$db_connect = db_connect();
	
	$array = pg_query($db_connect, "select cart from ".$table." where id = '".$id."'");
	$array = pg_fetch_all($array);
	
	$array = $array[0]['cart'];
	
	if ($array == "{}" || empty($array))
		return false;
	
	$array = str_replace("{", "", $array);
	$array = str_replace("}", "", $array);
	$array = explode(",", $array);
	
	if (!isset($_SESSION['cart']))
	{
		$_SESSION['cart'][] = array();
		$index = 0;
	}
	else
	{
		$index = count($_SESSION['cart']);
	}
	
	for ($i = 0, $k = $index; $i < count($array); $i += 3, $k++)
	{
		$arr = array('idItem' => $array[$i], 'amountItem' => $array[$i + 1]);
		if ($array[$i + 2] != "empty")
			$arr = array_merge_recursive($arr, array('variant' => $array[$i + 2]));
		
		$_SESSION['cart'][$k]= $arr;
	}
	pg_close($db_connect);
	return true;
}
function createTableUsers()
{
	global $users;
	$db_connect = db_connect();
	pg_query($db_connect, "create table if not exists ".$users." (
                                 id serial,
								 fio varchar,
								 phone varchar,
								 mail varchar unique,
								 password varchar,
								 town varchar,
								 street varchar,
								 house varchar,
								 flat varchar,
								 date varchar,
								 cart text[][]
								 );");
	pg_close($db_connect);	
}
function createTableOrders()
{
	global $orders;
	$db_connect = db_connect();
	pg_query($db_connect, "create table if not exists ".$orders." (
                                 id serial,
								 userid varchar,
								 status varchar,
								 symma real,
								 town varchar,
								 street varchar, 
								 house varchar,
								 flat varchar,
								 delivery varchar,
								 comment varchar,
								 cart text[][], 
								 date varchar);");
	pg_close($db_connect);	
}
//---------------------------------------------------------------------register.php-------------------------------------------------
function createUserByRegistration()
{
	global $users;
	$db_connect = db_connect();
	$today = date("Y-m-d H:i"); 
	$password = trim($_POST['password']);
	$id = pg_query($db_connect, "insert into ".$users." (fio, phone, mail, password, date) values 
                                             ('".trim($_POST['fio'])."', '".trim($_POST['phone'])."', '".trim($_POST['mail'])."', '".trim($password)."', 
											 '".$today."')returning id;");
	
	$id = pg_fetch_row($id);
	
	pg_close($db_connect);
	$_SESSION['idUser'] =  $id[0];
}
//---------------------------------------------------------------------account.php-------------------------------------------------
function getUser($idUser)
{
	global $users;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select * from ".$users." where id = '".$idUser."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array;
}
function getPassword($idUser)
{
	global $users;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select password from ".$users." where id = '".$idUser."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array[0]['password'];
}
function saveUser($idUser)
{
	global $users, $adminInformation, $mistake, $mistakeOldPassword;
	$password = getPassword($idUser);
	$oldPassword = trim($_POST['oldPassword']);
	$db_connect = db_connect();
	$mail = trim($_POST['mail']);
	if ($_POST['mail'] != $_SESSION['mail'] && checkMail($_POST['mail']))
	{
		$mistakeMail = "(E-mail is exists. Type another e-mail!)";	
		return null;
	}
	if ($oldPassword != "")
	{
		if ($oldPassword != $password)
		{
			$mistakeOldPassword = "(Не вверный старый пароль!)";
			return null;
		}
		else
		{
			$password = trim($_POST['password']);
		}
		
	}
	pg_query($db_connect, "update ".$users." set 
												fio = '".trim($_POST['fio'])."',
												phone = '".trim($_POST['phone'])."',
												mail = '".$mail."',
												town = '".trim($_POST['town'])."',
												street = '".trim($_POST['street'])."',
												house = '".trim($_POST['house'])."', 
												flat = '".trim($_POST['flat'])."',
												password = '".$password."'
												where id = '".$idUser."';");
	
	$adminInformation = "(Данные сохранены!)";	
	pg_close($db_connect);	
}

function getOrdersByUser($idUser)
{
	createTableOrders();
	global $orders;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select * from ".$orders." where userid = '".$idUser."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array;
}
function getOrders()
{
	createTableOrders();
	global $orders;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select * from ".$orders);
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array;
}
//---------------------------------------------------------------------login.php-------------------------------------------------
 function getPasswordByMail($mail)
 {
	global $users;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select password from ".$users." where mail = '".$mail."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	return $array[0]['password'];
 }
 
 function getUserByMail($mail)
 {
	global $users;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select id from ".$users." where mail = '".$mail."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	return $array[0]['id'];
 }
 //---------------------------------------------------------------------users.php-------------------------------------------------
 function getUsers()
 {
	createTableUsers();
	global $users;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select * from ".$users);
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	return $array;
 }
 function deleteUseraById($id)
 {
	global $users;
	$db_connect = db_connect();
	pg_query($db_connect, "delete from ".$users." where id = '".$id."'");
	pg_close($db_connect);
 }
 function deleteOrdersByIdUsera($id)
 {
	global $orders;
	$db_connect = db_connect();
	pg_query($db_connect, "delete from ".$orders." where userid = '".$id."'");
	pg_close($db_connect);
 }
 
  //---------------------------------------------------------------------users.php-------------------------------------------------
  function checkStatus($status, $string, $classColor)
  {
	  global $class;
	  if ($status == $string)
	  {
		  $class = $classColor;
		  return "selected";
	  }
	  return "";
  }
  
  //----------------------------------------------------------------------changeOrderStatus.php---------------------------------
  function changeOrderStatusById($id, $status)
  {
	global $orders;
	$db_connect = db_connect();
	pg_query($db_connect, "update ".$orders." set status = '".$status."' where id= '".$id."';");
	pg_close($db_connect);	
  }
  //---------------------------------------------------------------------order_information.php---------------------------------
  function getOrder($id)
  {
	global $orders;
	$db_connect = db_connect();
	$array = pg_query($db_connect, "select * from ".$orders." where id = '".$id."'");
	$array = pg_fetch_all($array);
	pg_close($db_connect);
	
	return $array[0];  
  }
  function deleteOrderById($id)
 {
	global $orders;
	$db_connect = db_connect();
	pg_query($db_connect, "delete from ".$orders." where id = '".$id."'");
	pg_close($db_connect);
 }
?>