<?php

//start session
session_start();

//setup logger
// require_once 'KLogger.php';
// $logger = new KLogger( "listdata.txt", KLogger::DEBUG);

//grab list name
$listname = $_POST['listname'];
//grab user id
$userid = $_SESSION['userIdentification'];

//set session listname for keeping track of last list
$_SESSION['currentListName'] = $listname;

//initialize Dao
require_once 'Dao.php';
$dao = new Dao();

//grab list data
$listData = $dao->getListData($userid, $listname);

//Create initial html with new list item button
$retHTML = '<li class="create-list-item"><button type="button" id="create-new-item-button" class="h-100 w-100 list-button" data-toggle="modal" data-target="#itemModal">Create New List Item (+)</button></li>';

//iterate through list and create li's
foreach($listData as $key => $value) {
    $name = $value['name'];
    $link = $value['link'];
    $price = $value['price'];

    $name = htmlspecialchars($name, ENT_QUOTES);
    $link = htmlspecialchars($link, ENT_QUOTES);
    $price = htmlspecialchars($price, ENT_QUOTES);

    $retHTML = $retHTML . '<li class="current-list-item"><div class="item-name">' . $name . '</div><div class="item-link">' . $link . '</div><div class="item-price">' . $price . '</div></li>';
}

//return list data to ajax
echo $retHTML;
?>