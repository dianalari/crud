<?php
/**
 * Created by PhpStorm.
 * User: diana.lari
 * Date: 11/14/2018
 * Time: 12:19 PM
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Repository\ProductRepository;
use Mockery;

class ProductServiceTest extends TestCase
{
    /** @var EntityManager|Mockery\MockInterface $entityManager */
    private $entityManager;

    /** @var ProductService */
    private $productService;

    /** @var ProductRepository|Mockery\MockInterface $entityRepositoryMock */
    private $entityRepositoryMock;

    public function setUp()
    {
        $this->entityManager = \Mockery::mock(EntityManager::class);
        $this->entityRepositoryMock = \Mockery::mock(ProductRepository::class);
        $this->productService = new ProductService($this->entityManager);
    }

    public function testSaveProductShouldReturnIdOnSuccess(): void
    {
        $this->entityManager->shouldReceive('persist')->withAnyArgs();
        $this->entityManager->shouldReceive('flush');

        $productData = array(
            'name' => 'unit',
            'description' => 'unit',
            'price' => '1.1',
        );

        $result = $this->productService->saveProduct($productData);

        $this->assertTrue($result);
    }

    /**
     * TODO
     * @expectedException \Exception
     */
    public function testSaveProductWithBadDataThrowsException(): void
    {
        $this->entityManager->shouldReceive('persist')->withAnyArgs();
        $this->entityManager->shouldReceive('flush');

        $productData = array(
            'na' => 'true',
            'description' => 'unit',
            'price' => '1.1',
        );

        $result = $this->productService->saveProduct($productData);

        $this->assertTrue($result);
    }

    public function testShowProduct(): void
    {
        $id = 3;
        $product = new Product();
        $product->setPrice(1.1);
        $product->setDescription('test');
        $product->setName('test');
        $product->setId($id);

        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Product::class)
            ->andReturn($this->entityRepositoryMock);

        $this->entityRepositoryMock
            ->shouldReceive('findOneBy')
            ->once()
            ->andReturn($product);

        $result = $this->productService->showProduct($id);

        $this->assertEquals($product, $result);
    }

    public function testShowAll(): void
    {
        $product1 = new Product();
        $product1->setPrice(1.1);
        $product1->setDescription('test');
        $product1->setName('test');
        $product1->setId(1);

        $product2 = new Product();
        $product2->setPrice(1.1);
        $product2->setDescription('test');
        $product2->setName('test');
        $product2->setId(2);

        $products_data = array($product1, $product2);

        $this->entityManager
        ->shouldReceive('getRepository')
        ->with(Product::class)
        ->andReturn($this->entityRepositoryMock);

        $this->entityRepositoryMock
            ->shouldReceive('findAll')
            ->once()
            ->andReturn($products_data);

        $result = $this->productService->showAllProducts();

        $this->assertEquals($products_data, $result);
    }

    public function testUpdateProduct(): void
    {
        $id = 3;
        $product = new Product();
        $product->setPrice(1.1);
        $product->setDescription('test');
        $product->setName('test');
        $product->setId($id);

        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Product::class)
            ->andReturn($this->entityRepositoryMock);

        $this->entityRepositoryMock
            ->shouldReceive('findOneBy')
            ->once()
            ->andReturn($product);

        $this->entityManager->shouldReceive('flush');

        $productData = array(
            'name' => 'unit',
            'description' => 'unit',
            'price' => '1.1',
        );

        $result = $this->productService->updateProduct($id, $productData);

        $this->assertTrue($result);
    }

    /**
     * TODO
     * @expectedException \Exception
     */
    public function testUpdateProductWithBadDataThrowsException(): void
    {
        $id = 3;
        $product = new Product();
        $product->setPrice(1.1);
        $product->setDescription('test');
        $product->setName('test');
        $product->setId($id);

        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Product::class)
            ->andReturn($this->entityRepositoryMock);

        $this->entityRepositoryMock
            ->shouldReceive('findOneBy')
            ->once()
            ->andReturn($product);

        $this->entityManager->shouldReceive('flush');

        $productData = array(
            'na' => 'unit',
            'description' => 'unit',
            'price' => '1.1',
        );

        $result = $this->productService->updateProduct($id, $productData);

        $this->assertTrue($result);
    }

    public function testRemoveProduct(): void
    {
        $id = 3;
        $product = new Product();
        $product->setPrice(1.1);
        $product->setDescription('test');
        $product->setName('test');
        $product->setId($id);

        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Product::class)
            ->andReturn($this->entityRepositoryMock);

        $this->entityRepositoryMock
            ->shouldReceive('findOneBy')
            ->once()
            ->andReturn($product);

        $this->entityManager
            ->shouldReceive('remove')
            ->with($product);

        $this->entityManager->shouldReceive('flush');

        $result = $this->productService->removeProduct($id);

        $this->assertTrue($result);
    }
}