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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');

            // Define foreign keys separately
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('quantity')->default(1); // Quantity of the product
            $table->decimal('unit_price', 10, 2); // Price per unit at the time of purchase
            $table->decimal('discount', 10, 2)->default(0.00); // Discount applied to this item
            $table->decimal('subtotal', 10, 2); // Total after applying discount (unit_price * quantity - discount)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
