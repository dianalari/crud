<?php
/**
 * Created by PhpStorm.
 * User: diana.lari
 * Date: 11/13/2018
 * Time: 10:07 AM
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $productData
     * @return Product
     * @throws \Exception
     */
    public function saveProduct(array $productData): Product
    {
        $this->assertArrayProduct($productData);
        $product = new Product();
        $product->setName($productData['name']);
        $product->setDescription($productData['description']);
        $product->setPrice((float)$productData['price']);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function showProduct(int $id): Product
    {
        $product = $this->findProductById($id);

        return $product;
    }

    /**
     * @return array
     */
    public function showAllProducts(): array
    {
        $ProductRepository = $this->entityManager->getRepository(Product::class);
        $products = $ProductRepository->findAll();

        return $products;
    }

    /**
     * @param int $id
     * @param array $productData
     * @return Product
     * @throws \Exception
     */
    public function updateProduct(int $id, array $productData): Product
    {
        $this->assertArrayProduct($productData);

        $product = $this->findProductById($id);

        $product->setName($productData['name']);
        $product->setDescription($productData['description']);
        $product->setPrice((float)$productData['price']);

        $this->entityManager->flush();

        return $product;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function removeProduct(int $id): bool
    {
        $product = $this->findProductById($id);

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return true;
    }

    private function findProductById(int $id): Product
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->entityManager->getRepository(Product::class);
        $product = $productRepository->findOneBy(['id' => $id]);

        if (!$product instanceof Product) {
            throw new NotFoundHttpException('No product found with id = ' . $id);
        }

        return $product;
    }

    /**
     * @param array $productData
     * @throws \Exception
     */
    private function assertArrayProduct(array $productData): void
    {
        $required_keys = array('name', 'description', 'price');

        if (count(array_intersect_key(array_flip($required_keys), $productData)) !== count($required_keys)) {
            throw new \Exception('Array keys');
        }
    }
}
