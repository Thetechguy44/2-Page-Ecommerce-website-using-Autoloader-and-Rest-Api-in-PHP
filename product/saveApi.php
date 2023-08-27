<?php

require_once '../autoload/autoloader.php';

use App\Database;
use App\Dvd;
use App\Book;
use App\Furniture;

$config = require '../config.php';
$db = new Database($config);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonInput = file_get_contents('php://input');
    $productData = json_decode($jsonInput, true);

    $action = isset($productData['action']) ? $productData['action'] : '';

    if (isset($productData['sku'])) {
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

            // Save the SKU in a session
            session_start();
            $_SESSION['last_added_sku'] = $sku;

            // Return a success response
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Product saved successfully', 'redirect' => 'index.php']);
        } catch (\Exception $e) {
            // Handle the exception (e.g., database error) and return an error response
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Failed to save the product']);
        }
    } elseif ($action === 'cancel') {
        // Handle cancel action and database removal
        try {
            session_start();
            if (isset($_SESSION['last_added_sku'])) {
                $lastAddedSku = $_SESSION['last_added_sku'];
                $stmt = $db->getConnection()->prepare("DELETE FROM products WHERE sku = :sku");
                $stmt->bindParam(':sku', $lastAddedSku, PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
            }

            // Return a success response
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Product canceled successfully', 'redirect' => 'index.php']);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Failed to cancel the product']);
        }
    }else{

    $productIds = $productData['productIds'];
    // Loop through the selected product IDs and delete them from the database
    $deleteStatement = $db->getConnection()->prepare("DELETE FROM products WHERE id = :productId");

    // Loop through the selected product IDs and execute the delete statement
    foreach ($productIds as $productId) {
        $deleteStatement->bindParam(':productId', $productId, PDO::PARAM_INT);
        $deleteStatement->execute();
    }

    // Return a success response
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Products deleted successfully']);
  }
}
