<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('admin can create product with main and gallery images', function () {
    Storage::fake('public');

    // create admin user and category manually
    $admin = User::create([
        'first_name' => 'Admin',
        'last_name' => 'User',
        'email' => 'admin@abitaofficedesign.com',
        'password' => 'password',
        'role' => 'super_admin',
        'status' => 'active',
    ]);
    $category = Category::create(['name' => 'Test Cat', 'slug' => 'test-cat']);

    $response = $this->actingAs($admin)
        ->post(route('admin.products.store'), [
            'name' => 'My Product',
            'slug' => 'my-product',
            'description' => 'A description',
            'categoryId' => $category->id,
            'image' => UploadedFile::fake()->image('main.jpg'),
            'specifications' => [],
            'customizations' => [],
            'images' => [
                ['file' => UploadedFile::fake()->image('one.jpg'), 'alt' => 'One', 'order' => 1],
                ['file' => UploadedFile::fake()->image('two.jpg'), 'alt' => 'Two', 'order' => 2],
            ],
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('products', ['name' => 'My Product']);
    $product = Product::where('name', 'My Product')->first();

    // main image stored
    Storage::disk('public')->assertExists($product->imageUrl);

    // gallery images stored and in DB
    $this->assertCount(2, $product->images);
    foreach ($product->images as $img) {
        Storage::disk('public')->assertExists($img->url);
    }
});
