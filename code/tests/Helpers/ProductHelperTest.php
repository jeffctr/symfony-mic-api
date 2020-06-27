<?php

namespace App\Tests\Helpers;

use App\Entity\Product;
use App\Helpers\ProductHelper;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProductHelperTest extends TestCase
{
//    /**
//     * @param array $productValues
//     * @param array $expected
//     * @param bool $exceptionExpected
//     * @dataProvider dataProviderTestGetModel
//     */
//    public function testGetModel(
//        array $productValues,
//        array $expected,
//        bool $exceptionExpected = false
//    ) {
//        if ($exceptionExpected) {
//            $this->expectException(InvalidArgumentException::class);
//        }
//
//        $testProduct = new Product();
//        $testProduct->setName($productValues['name']);
//        $testProduct->setPrice((float) $productValues['price']);
//        $testProduct->setImage($productValues['image']);
//        $testProduct->setRating((int) $productValues['Rating']);
//
//        $result = ProductHelper::getModel($testProduct);
//        $this->assertEquals($result, $expected);
//    }
//
//    /**
//     * Data provider for testGetModel
//     */
//    public function dataProviderTestGetModel()
//    {
//        $testName = 'blue flower';
//        $testPrice = 80;
//        $testImage = 'assets/blue-flower.png';
//        $testRating = 5;
//
//        $testCases = [];
//        $availableStatuses = [
//            Product::STATUS_AVAILABLE,
//            Product::STATUS_PENDING,
//            Product::STATUS_SOLD,
//        ];
//
//        foreach ($availableStatuses as $availableStatus) {
//            $testCases["Product, status $availableStatus"] = [
//                [
//                    'name' => $testName,
//                    'price' => $testPrice,
//                    'image' => $testImage,
//                    'rating' => $testRating,
//                ],
//                [
//                    'id' => null,
//                    'name' => $testName,
//                    'price' => $testPrice,
//                    'image' => $testImage,
//                    'rating' => $testRating,
//                ],
//            ];
//        }
//
//        return $testCases;
//    }
}
