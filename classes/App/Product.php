<?php
// classes/Product.php

namespace App;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $db;

    public function __construct($sku, $name, $price, Database $db)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->db = $db;
    }

    // Abstract methods for type-specific attributes and display
    abstract public function getAttributesHTML();
    abstract public function save();

    // Getters and setters

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
}
