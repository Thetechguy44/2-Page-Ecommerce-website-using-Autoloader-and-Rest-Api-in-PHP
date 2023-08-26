<?php

require_once '../autoload/autoloader.php';

use App\Database;
use App\Dvd;
use App\Book;
use App\Furniture;

$config = require '../config.php';
$db = new Database($config);

// Check if the SKU parameter is present in the URL
if (isset($_GET['sku'])) {
    $sku = $_GET['sku'];

    $query = "SELECT * FROM products WHERE sku = :sku";
    $statement = $db->getConnection()->prepare($query);
    $statement->execute(['sku' => $sku]);
    $productData = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$productData) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        exit;
    }

    // Return product data as JSON
    header('Content-Type: application/json');
    echo json_encode($productData);
} else {
    // If no SKU parameter, retrieve all products
    $query = "SELECT * FROM products";
    $statement = $db->getConnection()->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Return product data array as JSON
    header('Content-Type: application/json');
    echo json_encode($products);
}
?>
