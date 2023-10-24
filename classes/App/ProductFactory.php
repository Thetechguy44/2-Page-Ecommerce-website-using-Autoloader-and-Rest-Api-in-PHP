<?php

namespace App;

class ProductFactory
{
    public static function createBook($productData, $db)
    {
        Validations::validateNumericFields(['weight'], $productData);
        return new Book(
            $productData['sku'],
            $productData['name'],
            $productData['price'],
            $productData['weight'],
            $db
        );
    }

    public static function createDvd($productData, $db)
    {
        Validations::validateNumericFields(['size'], $productData);
        return new Dvd(
            $productData['sku'],
            $productData['name'],
            $productData['price'],
            $productData['size'],
            $db
        );
    }

    public static function createFurniture($productData, $db)
    {
        Validations::validateNumericFields(['height', 'width', 'length'], $productData);
        return new Furniture(
            $productData['sku'],
            $productData['name'],
            $productData['price'],
            $productData['height'],
            $productData['width'],
            $productData['length'],
            $db
        );
    }
}
