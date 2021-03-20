<?php

session_start();

require_once 'KLogger.php';

$logger = new KLogger( "listdata.txt", KLogger::DEBUG);



$listname = $_POST['listname'];
$userid = $_SESSION['userIdentification'];

//set session listname
$_SESSION['currentListName'] = $listname;

require_once 'Dao.php';
$dao = new Dao();

$listData = $dao->getListData($userid, $listname);

$logger->LogDebug("List data: " . print_r($listData, 1));

$retHTML = '<li class="create-list-item"><button type="button" class="h-100 w-100 list-button" data-toggle="modal" data-target="#itemModal">Create New List Item (+)</button></li>';

foreach($listData as $key => $value) {
    $name = $value['name'];
    $link = $value['link'];
    $price = $value['price'];

    $retHTML = $retHTML . '<li class="current-list-item"><div class="item-name">' . $name . '</div><div class="item-link">' . $link . '</div><div class="item-price">' . $price . '</div></li>';
    $logger->LogDebug("Found Item: " . $name . " with link: " . $link . " and price: " . $price);
}

echo $retHTML;

//echo print_r($retHTML, 1);

?>