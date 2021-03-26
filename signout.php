<?php
//start session and destroy it
session_start();
$_SESSION['authenticated'] = 0;
session_destroy();
header('Location: signin.php');
exit;
