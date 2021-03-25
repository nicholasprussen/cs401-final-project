<?php

session_start();

require_once '../KLogger.php';

$logger = new KLogger( "createlist.txt", KLogger::DEBUG);

$logger->LogDebug(print_r($_POST, 1));

$userid = $_SESSION['userIdentification'];
$listname = $_SESSION['currentListName'];

$name = $_POST['itemname'];
$link = "null";
if(isset($_POST['itemlink'])){
    $link = $_POST['itemlink'];
}
$price = $_POST['itemprice'];


require_once '../Dao.php';
$dao = new Dao();

$dao->createListItem($userid, $listname, $name, $link, $price);




if ($_SESSION['authenticated']) {
    header('Location: ../mylists.php');
    exit;
} else {
    header('Location: ../signin.php');
    exit;
}

?>