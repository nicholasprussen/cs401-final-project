<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

require_once '../Dao.php';
$dao = new Dao();
$_SESSION['authenticated'] = $dao->userExists($email, $password);



if ($_SESSION['authenticated']) {
    $_SESSION['userIdentification'] = $dao->userIdentification($email, $password);
    header('Location: ../home.php');
    exit;
} else {
    header('Location: ../signin.php');
    exit;
}

?>