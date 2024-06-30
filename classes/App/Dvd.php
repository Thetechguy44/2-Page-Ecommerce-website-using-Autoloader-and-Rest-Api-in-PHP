<?php

namespace App;

class Dvd extends Product
{
    protected $size;

    public function __construct($sku, $name, $price, $size, Database $db)
    {
        parent::__construct($sku, $name, $price, $db);
        $this->size = $size;
    }

    public function getAttributesHTML()
    {
        return "Size: {$this->size} MB";
    }

    public function save()
    {
        $query = "INSERT INTO products (sku, name, price, productType, size) 
                  VALUES (:sku, :name, :price, 'dvd', :size)";
        
        $statement = $this->db->getConnection()->prepare($query);
        $statement->execute([
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'size' => $this->size
        ]);
    }
}
