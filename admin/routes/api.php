<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\QuoteController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Info(
 *     title="AbitaDash API",
 *     version="1.0.0",
 *     description="Public API for AbitaDash - Categories and Products"
 * )
 *
 * @OA\Server(
 *     url="/api/v1",
 *     description="API Server"
 * )
 *
 * @OA\PathItem(
 *     path="/api/v1/categories",
 *     @OA\Get(
 *         summary="Get all categories",
 *         description="Retrieve all product categories for the home page",
 *         tags={"Categories"},
 *         @OA\Response(
 *             response=200,
 *             description="List of categories",
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(
 *                     property="data",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer"),
 *                         @OA\Property(property="name", type="string"),
 *                         @OA\Property(property="slug", type="string"),
 *                         @OA\Property(property="description", type="string"),
 *                         @OA\Property(property="imageUrl", type="string")
 *                     )
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\PathItem(
 *     path="/api/v1/categories/{categorySlug}/products",
 *     @OA\Get(
 *         summary="Get products by category",
 *         description="Retrieve all products for a specific category by its slug",
 *         tags={"Products"},
 *         @OA\Parameter(
 *             name="categorySlug",
 *             in="path",
 *             description="The category slug",
 *             required=true,
 *             @OA\Schema(type="string")
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="List of products in category",
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(
 *                     property="data",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer"),
 *                         @OA\Property(property="name", type="string"),
 *                         @OA\Property(property="slug", type="string"),
 *                         @OA\Property(property="description", type="string"),
 *                         @OA\Property(property="imageUrl", type="string"),
 *                         @OA\Property(property="categoryId", type="integer")
 *                     )
 *                 )
 *             )
 *         ),
 *         @OA\Response(response=404, description="Category not found")
 *     )
 * )
 *
 * @OA\PathItem(
 *     path="/api/v1/products/{productSlug}",
 *     @OA\Get(
 *         summary="Get product with related products",
 *         description="Retrieve a single product by slug with 3 random related products from the same category",
 *         tags={"Products"},
 *         @OA\Parameter(
 *             name="productSlug",
 *             in="path",
 *             description="The product slug",
 *             required=true,
 *             @OA\Schema(type="string")
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="Product details with related products",
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(
 *                     property="data",
 *                     type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="name", type="string"),
 *                     @OA\Property(property="slug", type="string"),
 *                     @OA\Property(property="description", type="string"),
 *                     @OA\Property(property="imageUrl", type="string"),
 *                     @OA\Property(property="categoryId", type="integer")
 *                 ),
 *                 @OA\Property(
 *                     property="relatedProducts",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer"),
 *                         @OA\Property(property="name", type="string"),
 *                         @OA\Property(property="slug", type="string"),
 *                         @OA\Property(property="description", type="string"),
 *                         @OA\Property(property="imageUrl", type="string"),
 *                         @OA\Property(property="categoryId", type="integer")
 *                     )
 *                 )
 *             )
 *         ),
 *         @OA\Response(response=404, description="Product not found")
 *     )
 * )
 */

Route::prefix('v1')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/categories/{categorySlug}/products', [ProductController::class, 'byCategory']);
    Route::get('/products/{productSlug}', [ProductController::class, 'show']);
    Route::post('/quotes', [QuoteController::class, 'store']);
    Route::post('/contact-messages', [ContactMessageController::class, 'store']);
});
