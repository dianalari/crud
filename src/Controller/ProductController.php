<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\DTOInterface;
use App\Entity\Product;
use App\Entity\ProductDTO;
use App\Service\ProductService;
use App\Service\SerializerFactory\SerializerFactoryInterface;
use App\Service\ValidationManager\ValidationManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use Swagger\Annotations as SWG;

class ProductController extends AbstractController
{
    /**
     * Save new Product
     *
     * @Post("/api/product")
     *
     * @SWG\Post(
     *  consumes={"application/json"},
     *  produces={"application/json"},
     *  tags={"product"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          description="json order object",
     *              @SWG\Schema(
     *               type="object",
     *               required={"name", "description", "price"},
     *                  @SWG\Property(
     *                    type="string",
     *                    property="name",
     *                    example="Product Name"
     *                  ),
     *                  @SWG\Property(
     *                    type="string",
     *                    property="description",
     *                    example="Product Description"
     *                  ),
     *                  @SWG\Property(
     *                    type="float",
     *                    property="price",
     *                    example="10.3"
     *                   ),
     *              )
     *      ),
     *     @SWG\Response(
     *     response=200,
     *     description="New product added successfully!"
     *     )
     * )
     *
     * @param Request $request
     *
     * @param ProductService $productService
     * @param SerializerFactoryInterface $serializerFactory
     * @param ValidationManagerInterface $validationManager
     * @return Response
     * @throws \Exception
     */
    public function saveProductAction(Request $request, ProductService $productService, SerializerFactoryInterface $serializerFactory, ValidationManagerInterface $validationManager): Response
    {
        /** @var SerializerInterface $serializer */
        $serializer = $serializerFactory->getSerializer();
        /** @var DTOInterface $productDTO */
        $productDTO = $serializer->deserialize($request->getContent(), ProductDTO::class, 'json');
        $validationManager->validateDTO($productDTO);
        $productData = $serializer->deserialize($request->getContent(), 'array', 'json');
        /** @var Product $product */
        $product = $productService->saveProduct($productData);
        $serializedProduct = $serializer->serialize($product, 'json');

        return new Response($serializedProduct, 200);
    }

    /**
     * Show product by id
     *
     * @Get("api/product/{id<\d+>}", name="product_show")
     * @SWG\Get(
     *     summary="Returns the product by id",
     *     description="Product show",
     *     operationId="productShow",
     *     tags={"product"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Product id",
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *          response=400,
     *          description="Bad Request"
     *     )
     * )
     *
     * @param int $id
     *
     * @param ProductService $productService
     * @param SerializerFactoryInterface $serializerFactory
     * @return Response
     */
    public function showProductAction(int $id, ProductService $productService, SerializerFactoryInterface $serializerFactory): Response
    {
        /** @var Product $product */
        $product = $productService->showProduct($id);
        /** @var SerializerInterface $serializer */
        $serializer = $serializerFactory->getSerializer();
        $serializedProduct = $serializer->serialize($product, 'json');

        return new Response($serializedProduct, 200);
    }

    /**
     * Show all products
     *
     * @Get("api/product/all", name="products_show")
     * @SWG\Get(
     *     summary="Returns all products",
     *     description="Products show",
     *     operationId="productsShow",
     *     tags={"product"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *     )
     * )
     *
     * @param ProductService $productService
     * @param SerializerFactoryInterface $serializerFactory
     * @return Response
     */
    public function showAllProductsAction(ProductService $productService, SerializerFactoryInterface $serializerFactory): Response
    {
        /** @var Product[] $products */
        $products = $productService->showAllProducts();
        /** @var SerializerInterface $serializer */
        $serializer = $serializerFactory->getSerializer();
        $serializedProduct = $serializer->serialize($products, 'json');

        return new Response($serializedProduct, 200);
    }

    /**
     *  Update Product
     *
     * @Put("api/product/{id}", name="product_update")
     * @SWG\Put(
     *        operationId="updateProduct",
     *        summary="Update product",
     *     tags={"product"},
     * 		@SWG\Parameter(
     *            name="id",
     *            in="path",
     *            required=true,
     *            type="integer",
     *            description="Product id",
     *        ),
     * 		@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          description="json order object",
     *              @SWG\Schema(
     *               type="object",
     *                  @SWG\Property(
     *                    type="string",
     *                    property="name",
     *                    example="Product Name"
     *                  ),
     *                  @SWG\Property(
     *                    type="string",
     *                    property="description",
     *                    example="Product Description"
     *                  ),
     *                  @SWG\Property(
     *                    type="float",
     *                    property="price",
     *                    example="10.3"
     *                   ),
     *              )
     *      ),
     * 		@SWG\Response(
     *          response=200,
     *          description="Success",
     *     ),
     *    )
     *
     * @param int $id
     * @param Request $request
     *
     * @param ProductService $productService
     * @param SerializerFactoryInterface $serializerFactory
     * @param ValidationManagerInterface $validationManager
     * @return Response
     * @throws \Exception
     */
    public function updateProductAction(int $id, Request $request, ProductService $productService, SerializerFactoryInterface $serializerFactory, ValidationManagerInterface $validationManager): Response
    {
        /** @var SerializerInterface $serializer */
        $serializer = $serializerFactory->getSerializer();
        /** @var DTOInterface $productDTO */
        $productDTO = $serializer->deserialize($request->getContent(), ProductDTO::class, 'json');
        $validationManager->validateDTO($productDTO);
        $productData = $serializer->deserialize($request->getContent(), 'array', 'json');
        /** @var Product $product */
        $product =$productService->updateProduct($id, $productData);

        $serializedProduct = $serializer->serialize($product, 'json');

        return new Response($serializedProduct, 200);
    }

    /**
     *  Delete product by id
     *
     * @Delete("api/product/{id}", name="product_delete")
     * @SWG\Delete(
     *        operationId="deleteProduct",
     *        summary="Remove product entry",
     *      tags={"product"},
     * 		@SWG\Parameter(
     *            name="id",
     *            in="path",
     *            required=true,
     *            type="string",
     *        ),
     * 		@SWG\Response(
     *            response=200,
     *            description="success",
     *        ),
     *    )
     *
     * @param int $id
     *
     * @param ProductService $productService
     * @param SerializerFactoryInterface $serializerFactory
     * @return Response
     */
    public function removeProductAction(int $id, ProductService $productService, SerializerFactoryInterface $serializerFactory): Response
    {
        $productService->removeProduct($id);

        /** @var SerializerInterface $serializer */
        $serializer = $serializerFactory->getSerializer();
        $serializedResponse = $serializer->serialize([$id], 'json');

        return new Response($serializedResponse, 200);
    }

}
