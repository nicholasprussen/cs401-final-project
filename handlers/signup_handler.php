<?php

session_start();

require_once '../KLogger.php';

$logger = new KLogger( "signup_handler.txt", KLogger::DEBUG);

$logger->LogDebug(print_r($_POST, 1));

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];

require_once '../Dao.php';
$dao = new Dao();

if(!($dao->emailExists($email))) {
    if($password == $passwordConfirm){
        $dao->createUser($firstname, $lastname, $email, $password);
        $_SESSION['authenticated'] = $dao->userExists($email, $password);
    }
}



if ($_SESSION['authenticated']) {
    $_SESSION['userIdentification'] = $dao->userIdentification($email, $password);
    header('Location: ../home.php');
    exit;
} else {
    header('Location: ../signup.php');
    exit;
}

?>