<?php

session_start();

#logger
require_once '../KLogger.php';
$logger = new KLogger( "createlist.txt", KLogger::ERROR);

//get dao
require_once '../Dao.php';
$dao = new Dao();

//isEmpty func
function isEmpty($string)
{
    if ($string === "") {
        return True;
    } else {
        return False;
    }
}

#grab user id
$userid = $_SESSION['userIdentification'];

#error array
$errors = array();

#grab form inputs
$listname = $_POST['newlistname'];
$public = $_POST['public'];

if(isEmpty($listname)){
    $errors['listname'] = "List name cannot be empty";
} else {
    if($dao->userListExists($userid, $listname)){
        $errors['listname'] = "You already have a list with this name";
    }
}

#boolean for public lists
$isPublic = 0;

#set whether public
if ($public == 'on') {
    $isPublic = 1;
}

#create list
if(!isset($errors['listname'])){
    $dao->createUserList($userid, $listname, $isPublic);
}

#check if errors and redirect
if (isset($errors['listname'])) {
    $_SESSION['errors'] = $errors;
    if(isset($_SESSION['form'])){
        unset($_SESSION['form']);
    }
    $_SESSION['form'] = $_POST;
    if($isPublic){
        $_SESSION['form']['public'] = "on";
    }
    header('Location: ../mylists.php');
    exit;
}

#final redirect if successful
$_SESSION['currentListName'] = $listname;
header('Location: ../mylists.php');
exit;

?>