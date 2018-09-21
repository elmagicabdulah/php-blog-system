<?php

$db_user = "root";
$db_password = "";



try {
    $conn = new PDO('mysql:host=localhost;dbname=blog', $db_user, $db_password, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    echo "Can't connect: " . $e->getMessage();
}