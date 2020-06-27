<?php
namespace App\Helpers;


use App\Entity\Product;

class ProductHelper
{
    /**
     * @param Product $product
     * @return array
     */
    public static function getModel(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'rating' => $product->getRating(),
            'image' => $product->getImage(),
        ];
    }
}
