<?php

session_start();

//logger
require_once '../KLogger.php';
$logger = new KLogger( "signin_handler.txt", KLogger::ERROR);

//array to keep track of errors
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

//grab user info
$email = $_POST['email'];
$password = $_POST['password'];

//validate email
if(!isEmpty($email)) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Not a valid email address";
    }
} else {
    $errors['email'] = "Email cannot be empty";
}

//salt and hash password
$salt = "randomjunk";
$newpass = hash('sha256', $password.$salt);

//validate password
if(!isEmpty($password)){
    if(strlen($password) < 8){
        $errors['password'] = "Password cannot be shorter than 8 characters";
    } else{
        //make sure password follows restrictions
        require_once '../Dao.php';
        $dao = new Dao();
        $_SESSION['authenticated'] = $dao->userExists($email, $newpass);
    }
} else {
    $errors['password'] = "Password cannot be empty";
}

//check authenticated
if ($_SESSION['authenticated']) {
    //grab user id
    $_SESSION['userIdentification'] = $dao->userIdentification($email, $newpass);
    if(isset($_SESSION['form'])){
        unset($_SESSION['form']);
    }
    header('Location: ../home.php');
    exit;
} else {

    //check if no errors were logged
    if(!isset($errors['password']) && !isset($errors['email'])){
        $errors['loginFailed'] = "This email and/or password could not be found";
    }

    //assign session vars
    $_SESSION['errors'] = $errors;
    if(isset($_SESSION['form'])){
        unset($_SESSION['form']);
    }
    $_SESSION['form'] = $_POST;
    header('Location: ../signin.php');
    exit;
}
