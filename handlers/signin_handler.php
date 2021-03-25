<?php

session_start();

require_once '../KLogger.php';

$logger = new KLogger( "signin_handler.txt", KLogger::DEBUG);

//$logger->LogDebug(print_r($_POST, 1));
//$logger->LogDebug(print_r($_SESSION, 1));

$errors = array();

//validate user email
$email = $_POST['email'];

if($email != "") {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Not a valid email address";
    }
} else {
    $errors['email'] = "Email cannot be empty";
}

//validate password
$password = $_POST['password'];

if($password != ""){
    if(strlen($password) > 1 && strlen($password) <= 64){
        require_once '../Dao.php';
        $dao = new Dao();
        $_SESSION['authenticated'] = $dao->userExists($email, $password);
        $logger->LogDebug('Session attempted');
        if($_SESSION['authenticated']){
            $logger->LogDebug("Authenticated");
        }
        //$logger->LogDebug($_SESSION['authenticated']);
    } else {
        $errors['password'] = "Password is a maximum of 64 characters";
    }
    
} else {
    $errors['password'] = "Password cannot be empty";
}





if ($_SESSION['authenticated']) {
    $_SESSION['userIdentification'] = $dao->userIdentification($email, $password);
    if(isset($_SESSION['form'])){
        unset($_SESSION['form']);
    }
    header('Location: ../home.php');
    exit;
} else {
    if(!isset($errors['password']) && !isset($errors['email'])){
        $errors['loginFailed'] = "This email and/or password could not be found";
    }
    $_SESSION['errors'] = $errors;
    if(isset($_SESSION['form'])){
        unset($_SESSION['form']);
    }
    $_SESSION['form'] = $_POST;
    header('Location: ../signin.php');
    exit;
}

?>