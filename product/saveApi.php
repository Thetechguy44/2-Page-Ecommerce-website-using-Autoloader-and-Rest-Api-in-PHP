<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../autoload/Autoloader.php';

use App\Database;
use App\Dvd;
use App\Book;
use App\Furniture;
use App\ProductFactory;
use App\Validations; 

class SaveApi
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    //funtion to handle incoming request and saving to database
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonInput = file_get_contents('php://input');
            $productData = json_decode($jsonInput, true);
    
            $action = isset($productData['action']) ? $productData['action'] : '';
    
            if (isset($productData['sku'])) {
                $productType = $productData['productType'];
    
                $commonErrors = Validations::validateCommonFields($productData);
                $productTypeErrors = Validations::validateProductTypeFields($productType, $productData);
                $existingSkuError = Validations::validateExistingSku($productData['sku'], $this->db);
    
                $errors = array_merge($commonErrors, $productTypeErrors);
    
                if ($existingSkuError) {
                    $errors['sku'] = $existingSkuError;
                }
    
                if (empty($errors)) {
                    $product = $this->createProduct($productType, $productData, $this->db);
    
                    if ($product) {
                        try {
                            $product->save();
                            session_start();
                            $_SESSION['last_added_sku'] = $productData['sku'];
    
                            return ['message' => 'Product saved successfully', 'redirect' => 'index.php'];
                        } catch (\Exception $e) {
                            return ['error' => 'Failed to save the product'];
                        }
                    } else {
                        return ['error' => 'Invalid product type'];
                    }
                } else {
                    return ['errors' => $errors];
                }
            } elseif ($action === 'cancel') {
                return $this->cancelProduct($action);
            } elseif (isset($productData['productIds'])) {
                return $this->deleteProducts($productData);
            }
        }
    
        return ['error' => 'Invalid request'];
    }    
    
    //function to create product base on producttype before saving
    private function createProduct($productType, $productData)
    {
        Validations::validateCommonFields($productData);
    
        $methodName = 'create' . ucfirst($productType);
        
        if (method_exists(ProductFactory::class, $methodName)) {
            return ProductFactory::$methodName($productData, $this->db);
        } else {
            throw new \Exception('Invalid product type');
        }
    }
    
    //function for handling cancel product after saving 
    private function cancelProduct($action)
    {
        if ($action) {
            try {
                session_start();
                if (isset($_SESSION['last_added_sku'])) {
                    $lastAddedSku = $_SESSION['last_added_sku'];
                    $stmt = $this->db->getConnection()->prepare("DELETE FROM products WHERE sku = :sku");
                    $stmt->bindParam(':sku', $lastAddedSku, PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt->closeCursor();
                }

                return ['message' => 'Product canceled successfully', 'redirect' => 'index.php'];
            } catch (\Exception $e) {
                return ['error' => 'Failed to cancel the product'];
            }
        }

        return ['error' => 'Invalid product type'];
    }

    //function for handling mass deletion
    private function deleteProducts($productData)
    {
        $productIds = $productData['productIds'];
        // Loop through the selected product IDs and delete them from the database
        $deleteStatement = $this->db->getConnection()->prepare("DELETE FROM products WHERE id = :productId");

        // Loop through the selected product IDs and execute the delete statement
        foreach ($productIds as $productId) {
            $deleteStatement->bindParam(':productId', $productId, PDO::PARAM_INT);
            $deleteStatement->execute();
        }

        return ['message' => 'Products deleted successfully'];
    }
}

// Initialize the saveApi class 
$config = require '../config.php';
$db = new Database($config);
$api = new SaveApi($db);
$response = $api->handleRequest();

header('Content-Type: application/json');
echo json_encode($response);