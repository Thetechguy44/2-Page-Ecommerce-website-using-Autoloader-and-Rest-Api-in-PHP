<?php

namespace App;

class Validations
{
    //function for numeric field validation
    public static function validateNumericFields($fields, $productData)
    {
        $errors = [];

        foreach ($fields as $field) {
            if (!is_numeric($productData[$field])) {
                $errors[$field] = ucfirst($field) . ' must be a valid number.';
            }
        }

        if (!empty($errors)) {
            throw new \Exception('Invalid product data: ' . implode(', ', $errors));
        }
    }

    //function for common field validation
    public static function validateCommonFields($productData)
    {
        $requiredFields = ['sku', 'name', 'price', 'productType'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (!isset($productData[$field]) || empty($productData[$field])) {
                $errors[$field] = ucfirst($field) . ' field is required.';
            }
        }

        return $errors;
    }

    //function for existing sku validation
    public static function validateExistingSku($sku, $db)
    {
        $skuCheckQuery = "SELECT COUNT(*) FROM products WHERE sku = :sku";
        $skuCheckStatement = $db->getConnection()->prepare($skuCheckQuery);
        $skuCheckStatement->execute(['sku' => $sku]);
        $skuCount = $skuCheckStatement->fetchColumn();

        if ($skuCount > 0) {
            return 'This SKU has already been used';
        }

        return null; // No error
    }

    //function for producttype numeric field validation
    public static function validateProductTypeFields($productType, $productData)
    {
        $productTypeErrors = [];
        
        // Create the method name based on the product type
        $methodName = 'validate' . ucfirst($productType) . 'Fields';
    
        // Check if the method exists and call it
        if (method_exists(self::class, $methodName)) {
            $productTypeErrors = self::$methodName($productData);
        } else {
            throw new \Exception('Invalid product type');
        }
    
        return $productTypeErrors;
    }
    
    //prefix function for dvd numeric field validation
    private static function validateDvdFields($productData)
    {
        $productTypeErrors = [];
    
        if (!is_numeric($productData['size'])) {
            $productTypeErrors['size'] = 'Size must be a valid number.';
        }
    
        return $productTypeErrors;
    }
    
    //prefix function for book numeric field validation
    private static function validateBookFields($productData)
    {
        $productTypeErrors = [];
    
        if (!is_numeric($productData['weight'])) {
            $productTypeErrors['weight'] = 'Weight must be a valid number.';
        }
    
        return $productTypeErrors;
    }
    
    //prefix function for furniture numeric field validation
    private static function validateFurnitureFields($productData)
    {
        $productTypeErrors = [];
    
        if (!is_numeric($productData['height'])) {
            $productTypeErrors['height'] = 'Height must be a valid number.';
        }
    
        if (!is_numeric($productData['width'])) {
            $productTypeErrors['width'] = 'Width must be a valid number.';
        }
    
        if (!is_numeric($productData['length'])) {
            $productTypeErrors['length'] = 'Length must be a valid number.';
        }
    
        return $productTypeErrors;
    }
    
}
