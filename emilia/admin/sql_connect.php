<?php

    $host = 'localhost';
    $user = 'root';
    $password = 'mysql';
    $dbName = 'projekt_db';

    $mysqli = new mysqli($host,$user,$password,$dbName);

    $mysqli->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    $mysqli->query("SET CHARSET utf8");

    if ($error = $mysqli->connect_error){
        die("Wystąpił błąd! Błąd połączenia nr ".$error);
    }
?>