<?php
include("..\connect.php");
$category = $_GET['category'];

try {
    $sqlSelect = "SELECT items.name, items.price, items.quantity, items.FID_Category, category.c_name   FROM items, category WHERE  category.c_name = :category AND items.FID_Category = category.ID_Category";
    $stmt = $dbh->prepare($sqlSelect);
    $stmt->bindParam(':category', $category);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $xml = new SimpleXMLElement('<items/>');
    foreach ($result as $row) {
        $item = $xml->addChild('item');
        $item->addChild('name', $row['name']);
        $item->addChild('price', $row['price']);
        $item->addChild('quantity', $row['quantity']);
        $item->addChild('category', $row['c_name']);
    }

    header('Content-Type: text/xml');
    echo $xml->asXML();

} catch (PDOException $ex) {
    echo $ex->GetMessage();
}