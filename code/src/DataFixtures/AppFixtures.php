<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $load_data = json_decode(file_get_contents(__DIR__ . '/response.json'), true);
        foreach ($load_data['products'] as $value) {
            $product = new Product();
            $product->setName($value['name']);
            $product->setPrice($value['price']);
            $product->setImage($value['image']);
            $product->setRating($value['rating']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
