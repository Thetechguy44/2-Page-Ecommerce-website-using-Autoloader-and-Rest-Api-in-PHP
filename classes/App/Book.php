<?php

namespace App;

class Book extends Product
{
    protected $weight;

    public function __construct($sku, $name, $price, $weight, Database $db)
    {
        parent::__construct($sku, $name, $price, $db);
        $this->weight = $weight;
    }

    public function getAttributesHTML()
    {
        return "Weight: {$this->weight} KG";
    }

    public function save()
    {
        $query = "INSERT INTO products (sku, name, price, productType, weight) 
                  VALUES (:sku, :name, :price, 'book', :weight)";
        
        $statement = $this->db->getConnection()->prepare($query);
        $statement->execute([
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'weight' => $this->weight
        ]);
    }
}
