<?php

namespace App;

class ProductFactory
{
    //function create book product
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

    //function to create dvd product
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

    //function to create furniture product
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
