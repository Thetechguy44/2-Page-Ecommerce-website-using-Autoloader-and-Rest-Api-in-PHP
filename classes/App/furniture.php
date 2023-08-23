<?php
//classes/furniture.php

namespace App;

class Furniture extends Product
{
    protected $height;
    protected $width;
    protected $length;

    public function __construct($sku, $name, $price, $height, $width, $length, Database $db)
    {
        parent::__construct($sku, $name, $price, $db);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getAttributesHTML()
    {
        return "Height: {$this->height} H";
        return "Width: {$this->width} W";
        return "Length: {$this->length} L";
    }

    public function save()
    {
        $query = "INSERT INTO products (sku, name, price, productType, height, width, length) 
                  VALUES (:sku, :name, :price, 'furniture', :height, :width, :length,)";
        
        $statement = $this->db->getConnection()->prepare($query);
        $statement->execute([
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'height' => $this->height,
            'width' => $this->width,
            'length' => $this->length
        ]);
    }
}
