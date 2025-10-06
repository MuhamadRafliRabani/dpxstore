<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products_digiflazz', function (Blueprint $table) {
            $table->id();

            $table->string('product_name')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('seller_name')->nullable();
            $table->string('price')->nullable();
            $table->string('buyer_sku_code')->nullable();

            $table->boolean('buyer_product_status')->nullable();
            $table->boolean('seller_product_status')->nullable();
            $table->boolean('unlimited_stock')->nullable();
            $table->string('stock')->nullable();
            $table->boolean('multi')->nullable();

            $table->string('start_cut_off')->nullable();
            $table->string('end_cut_off')->nullable();
            $table->text('desc')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_digiflazz');
    }
};
