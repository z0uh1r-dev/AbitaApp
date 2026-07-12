<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->string('alt', 255)->nullable();
            $table->unsignedSmallInteger('order');
            $table->foreignId('productId')
                  ->constrained('products')
                  ->cascadeOnDelete();

            // Enforce unique order per product at the DB level
            $table->unique(['productId', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
