<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
{
    /**
     * @param string $method
     * @param string $url
     * @param int $expectedCode
     * @dataProvider dataProviderTestAll
     */
    public function testAll(string $method, string $url, int $expectedCode)
    {
        $client = static::createClient();
        $client->request($method, $url);

        $this->assertEquals($expectedCode, $client->getResponse()->getStatusCode());
    }

    /**
     * Data provider for testAll
     */
    public function dataProviderTestAll()
    {
        return [
            'Valid products request' => [
                'GET',
                '/products',
                Response::HTTP_OK,
            ],
        ];
    }

    /**
     * @param string $method
     * @param string $url
     * @param int $expectedCode
     * @dataProvider dataProviderTestOne
     */
    public function testOne(string $method, string $url, int $expectedCode)
    {
        $client = static::createClient();
        $client->request($method, $url);

        $this->assertEquals($expectedCode, $client->getResponse()->getStatusCode());
    }

    /**
     * Data provider for testOne
     */
    public function dataProviderTestOne()
    {
        return [
            'Valid product request' => [
                'GET',
                '/product/7',
                Response::HTTP_OK,
            ],
            'Invalid product request' => [
                'GET',
                '/product/1000',
                Response::HTTP_NOT_FOUND,
            ],
        ];
    }
}
