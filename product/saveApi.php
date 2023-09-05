<?php

require_once '../autoload/Autoloader.php';

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
      // Validate common inputs
      $requiredFields = ['sku', 'name', 'price', 'productType'];
      $errors = [];
      foreach ($requiredFields as $field) {
          if (!isset($productData[$field]) || empty($productData[$field])) {
              $errors[$field] = ucfirst($field) . 'Field is required.';
          }
      }

          // Check if SKU is already used
        $sku = $productData['sku'];
        $skuCheckQuery = "SELECT COUNT(*) FROM products WHERE sku = :sku";
        $skuCheckStatement = $db->getConnection()->prepare($skuCheckQuery);
        $skuCheckStatement->execute(['sku' => $sku]);
        $skuCount = $skuCheckStatement->fetchColumn();

        if ($skuCount > 0) {
            $errors['sku'] = 'This SKU has already been used';
        }

      if (!is_numeric($productData['price'])) {
          $errors['price'] = 'Price must be a valid number.';
      }

    
      $productType = $productData['productType'];
      $productTypeErrors = [];
      
      if ($productType === 'dvd' && !is_numeric($productData['size'])) {
          $productTypeErrors['size'] = 'Size must be a valid number.';
      }
      
      if ($productType === 'book' && !is_numeric($productData['weight'])) {
          $productTypeErrors['weight'] = 'Weight must be a valid number.';
      }
      
      if ($productType === 'furniture') {
          if (!is_numeric($productData['height'])) {
              $productTypeErrors['height'] = 'Height must be a valid number.';
          }
      
          if (!is_numeric($productData['width'])) {
              $productTypeErrors['width'] = 'Width must be a valid number.';
          }
      
          if (!is_numeric($productData['length'])) {
              $productTypeErrors['length'] = 'Length must be a valid number.';
          }
      }
      
      if (!in_array($productType, ['dvd', 'book', 'furniture'])) {
          $productTypeErrors['error'] = 'Invalid product type';
      }
      
      $errors = array_merge($errors, $productTypeErrors);

      // If there are validation errors, return error response
      if (!empty($errors)) {
          http_response_code(400); // Bad Request
          echo json_encode(['errors' => $errors]);
          exit;
      }

      // Create the appropriate product instance
      $product = match ($productType) {
          'dvd' => new Dvd($productData['sku'], $productData['name'], $productData['price'], $productData['size'], $db),
          'book' => new Book($productData['sku'], $productData['name'], $productData['price'], $productData['weight'], $db),
          'furniture' => new Furniture($productData['sku'], $productData['name'], $productData['price'], $productData['height'], $productData['width'], $productData['length'], $db)
      };

        // Save the product
        try {
            $product->save();

            // Save the SKU in a session
            session_start();
            $_SESSION['last_added_sku'] = $productData['sku'];

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
    }elseif (isset($productData['productIds'])){

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
