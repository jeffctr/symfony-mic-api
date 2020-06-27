<?php
namespace App\Controller;


use App\Entity\Product;
use App\Helpers\ProductHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    const VALID_PARAMS = ['name', 'price', 'image', 'rating'];

    /**
     * @Route("/products", name="product_all", methods={"GET"})
     *
     * @return mixed
     */
    public function all()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        $results = [];
        foreach ($products as $product) {
            $results[] = ProductHelper::getModel($product);
        }

        return $this->json($results);
    }

    /**
     * @Route("/product/{id}", name="product_one", methods={"GET"})
     *
     * @param int $id
     * @return mixed
     */
    public function one(int $id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            return $this->json(
                'Product not found',
                Response::HTTP_NOT_FOUND
            );
        }

        $result = ProductHelper::getModel($product);

        return $this->json($result);
    }


    /**
     * @Route("/product", name="product_put", methods={"POST"}) *
     *
     * @param Request $request
     * @return Response
     */
    public function createProduct(Request $request): Response
    {
        // Get request body content
        $content = $request->getContent();
        if (empty($content)) {
            return new Response('There is not valid content in your request', Response::HTTP_NO_CONTENT);
        }

        // Get content in array associative
        $content = json_decode($content);

        // Validate data where it is not ampty and accepted
        foreach ($content as $key => $value) {
            if (!in_array($key, self::VALID_PARAMS)) {
                return new Response("You have invalid params in teh data ${key}", Response::HTTP_NOT_FOUND);
            }
            if (empty($value)) {
                return new Response("Not empty values accepted ${key}", Response::HTTP_NOT_FOUND);
            }
        }

        $entityManager = $this->getDoctrine()->getManager();

        // Assessing the product
        $product = new Product();
        $product->setName($content->name);
        $product->setPrice((float) $content->price);
        $product->setRating((float) $content->rating);
        $product->setImage($content->image);

        // Persist the data without insertion
        $entityManager->persist($product);

        // Exec insertion into the DB
        $entityManager->flush();

        // Status 200 is by default
        return new Response('Saved new product with id '.$product->getId(), Response::HTTP_OK);
    }
}
