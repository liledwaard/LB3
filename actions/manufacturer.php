<?php
include("..\connect.php");
$manufacturer = $_GET['manufacturerName'];

try {
    $sqlSelect = "SELECT items.name, items.price, items.quantity, items.FID_Vendor, vendors.ID_Vendors, vendors.v_name  FROM items, vendors WHERE  vendors.v_name = :vendor AND items.FID_Vendor = vendors.ID_Vendors";
    $stmt = $dbh->prepare($sqlSelect);
    $stmt->bindParam(':vendor', $manufacturer);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Price</th><th>Number</th><th>Manufacturer</th></tr>";

    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['v_name'] . "</td>";
        echo "</tr>";
    }
} catch (PDOException $ex) {
    echo $ex->GetMessage();
}