<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../autoload/Autoloader.php';

use App\Database;
use App\Dvd;
use App\Book;
use App\Furniture;

class getApi {
    private $db;

    public function __construct($config) {
        $this->db = new Database($config);
    }

    //fuction handling get request
    public function handleGetRequest() {
        if (isset($_GET['sku'])) {
            $sku = $_GET['sku'];
            return $this->getProductBySku($sku);
        } else {
            return $this->getAllProducts();
        }
    }

    //fuction handling get request by sku
    private function getProductBySku($sku) {
        $query = "SELECT * FROM products WHERE sku = :sku";
        $statement = $this->db->getConnection()->prepare($query);
        $statement->execute(['sku' => $sku]);
        $productData = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$productData) {
            http_response_code(404);
            return ['error' => 'Product not found'];
        }

        return $productData;
    }

    //fuction handling get all product
    private function getAllProducts() {
        $query = "SELECT * FROM products";
        $statement = $this->db->getConnection()->prepare($query);
        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}

// Initialize the getApi class and handle the GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $config = require '../config.php';
    $api = new getApi($config);
    $response = $api->handleGetRequest();

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
