<?php

require_once 'Autoloader.php';

use App\Database;
use App\Dvd;
use App\Book;
use App\Furniture;

$config = require 'config.php';
$db = new Database($config);

$sku = $_GET['sku'];

$query = "SELECT * FROM products WHERE sku = :sku";
$statement = $db->getConnection()->prepare($query);
$statement->execute(['sku' => $sku]);
$productData = $statement->fetch(PDO::FETCH_ASSOC);

if (!$productData) {
    // Handle product not found scenario
    // Return an error response or appropriate status code
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit;
}

$type = $productData['type'];

if ($type === 'dvd') {
    $product = new Dvd($productData['sku'], $productData['name'], $productData['price'], $productData['size'], $db);
} elseif ($type === 'book') {
    $product = new Book($productData['sku'], $productData['name'], $productData['price'], $productData['weight'], $db);
} elseif ($type === 'furniture') {
    $product = new Furniture($productData['sku'], $productData['name'], $productData['price'], $productData['dimensions'], $db);
}

// Return product data as JSON
header('Content-Type: application/json');
echo json_encode($product->getAttributesHTML());
