<?php

session_start();

require_once '../KLogger.php';

$logger = new KLogger( "createlist.txt", KLogger::DEBUG);

$logger->LogDebug(print_r($_POST, 1));

$userid = $_SESSION['userIdentification'];

$listname = $_POST['newlistname'];
$public = $_POST['public'];
$isPublic;

if ($public == 'on') {
    $isPublic = 1;
} else {
    $isPublic = 0;
}


require_once '../Dao.php';
$dao = new Dao();


//$dao->createUserList($userid, $listname, $isPublic);

if(!($dao->userListExists($userid, $listname))) {
    $dao->createUserList($userid, $listname, $isPublic);
}



if ($_SESSION['authenticated']) {
    header('Location: ../mylists.php');
    exit;
} else {
    header('Location: ../signin.php');
    exit;
}

?>