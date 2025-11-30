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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Buyer
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Shop
            $table->foreignId('shop_id')
                ->constrained()
                ->onDelete('cascade');

            // Order details
            $table->decimal('total_cost', 12, 2);
            $table->enum('order_type', ['pickup', 'delivery']);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');

            // Payment details
            $table->enum('payment_method', ['midtrans'])->default('midtrans');
            $table->string('payment_status')->default('unpaid');
            $table->string('payment_id')->nullable();

            // Pickup code
            $table->string('pickup_code')->nullable();

            // Delivery details
            $table->string('delivery_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
