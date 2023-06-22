<?php
include("..\connect.php");
$minPrice = $_GET['minPrice'];
$maxPrice = $_GET['maxPrice'];

try {
    $sqlSelect = "SELECT * FROM items, category, vendors WHERE items.price BETWEEN :minPrice AND :maxPrice AND items.FID_Category = category.ID_Category AND items.FID_Vendor = vendors.ID_Vendors";
    $stmt = $dbh->prepare($sqlSelect);
    $stmt->bindParam(':minPrice', $minPrice);
    $stmt->bindParam(':maxPrice', $maxPrice);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response = "<table border='1'>";
    $response .= "<tr><th>Name</th><th>Price</th><th>Number</th><th>Manufacturer</th><th>Categorys</th></tr>";
    foreach ($result as $row) {
        $response .= "<tr>";
        $response .= "<td>" . $row['name'] . "</td>";
        $response .= "<td>" . $row['price'] . "</td>";
        $response .= "<td>" . $row['quantity'] . "</td>";
        $response .= "<td>" . $row['v_name'] . "</td>";
        $response .= "<td>" . $row['c_name'] . "</td>";
        $response .= "</tr>";
    }

    header('Content-Type: text/json');
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} catch (PDOException $ex) {
    echo $ex->GetMessage();
}