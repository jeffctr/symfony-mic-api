<?php
namespace App\Interfaces;

use App\Entity\Product;

interface ProductRepositoryInterface
{
    public function getProductById(int $id): Product;
}
