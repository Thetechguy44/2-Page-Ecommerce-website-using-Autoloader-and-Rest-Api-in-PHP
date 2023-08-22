<?php
// saveApi.php

require_once '../autoload/autoloader.php';

use App\Database;
use App\Dvd;
use App\Book;
use App\Furniture;

$config = require '../config.php';
$db = new Database($config);

if (isset($_POST['submit'])) {
    $jsonInput = file_get_contents('php://input');
    $productData = json_decode($jsonInput, true);

    $sku = $productData['sku'];
    $name = $productData['name'];
    $price = $productData['price'];
    $productType = $productData['productType'];

    // Handle other inputs based on productType
    $size = $productData['size'];
    $weight = $productData['weight'];
    $height = $productData['height'];
    $width = $productData['width'];
    $length = $productData['length'];

    // Create the appropriate product instance
    if ($productType === 'dvd') {
        $product = new Dvd($sku, $name, $price, $size, $db);
    } elseif ($productType === 'book') {
        $product = new Book($sku, $name, $price, $weight, $db);
    } elseif ($productType === 'furniture') {
        $product = new Furniture($sku, $name, $price, $height, $width, $length, $db);
    }

    // Save the product
    try {
        $product->save();
        // Return a success response
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Product saved successfully']);
    } catch (\Exception $e) {
        // Handle the exception (e.g., database error) and return an error response
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Failed to save the product']);
    }
}
