<?php

session_start();

//logger
require_once '../KLogger.php';
$logger = new KLogger( "createlist.txt", KLogger::ERROR);

//errors array
$errors = array();

//isEmpty func
function isEmpty($string)
{
    if ($string === "") {
        return True;
    } else {
        return False;
    }
}

//get session vars
$userid = $_SESSION['userIdentification'];
$listname = $_SESSION['currentListName'];

//get user input
$name = $_POST['itemname'];
$link = $_POST['itemlink'];
$price = $_POST['itemprice'];

$logger->LogError("Name: " . ($_POST['itemname']));
$logger->LogError("Link: " . ($_POST['itemlink']));
$logger->LogError("Price: " . ($_POST['itemprice']));

#get dao
require_once '../Dao.php';
$dao = new Dao();


#validate item name
if(isEmpty($name)){
    $logger->LogError("Item name is empty");
    $errors['itemname'] = "Item name cannot be empty";
}

#validate price
if(isEmpty($price)){
    $logger->LogError("Price is empty");
    $errors['price'] = "Price cannot be empty";
} else {
    if (!preg_match("/^[0-9]{0,6}(\.[0-9]{2})?$/", $price)){
        $logger->LogError("Invalid Price");
        $errors['price'] = "Invalid price";
    }
}

$logger->LogError($errors['price']);
$logger->LogError($errors['itemname']);

#insert item
if(!isset($errors['itemname']) && !isset($errors['price'])){
    $dao->createListItem($userid, $listname, $name, $link, $price);

    if(isset($_SESSION['errors'])){
        unset($_SESSION['errors']);
    }

    header('Location: ../mylists.php');
    exit;
}

$_SESSION['errors'] = $errors;
$_SESSION['form'] = $_POST;

header('Location: ../mylists.php');
exit;

?>