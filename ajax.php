<?php

function getInformation($name) {

    require_once 'Dao.php';
    $dao = new Dao();

    //$dao

    //return "I got this name: " . $name;
}

echo getInformation($_POST['name']);

?>