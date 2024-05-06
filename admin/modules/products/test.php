<?php


require_once '../../config.php';

$sqlShowProducts = "SELECT p.id, p.name, p.price, p.description, c.name AS category_name 
    FROM product p 
    INNER JOIN categories c ON p.category_id = c.id";
$products = $link->query($sqlShowProducts);

while ($row = $products->fetch_assoc()) {
    echo $row[1] . " | " . $row['name'] . " | " . $row['price'] . " | " . $row['description'] . " | " . $row['category_name'] . "<br>";
}
