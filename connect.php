<?php
try {
    $dsn = "mysql:host=localhost;dbname=eshop";
    $user = "root";
    $pass = "";
    $dbh = new PDO($dsn, $user, $pass);

} catch (PDOException $ex) {
    echo $ex->GetMessage();
}