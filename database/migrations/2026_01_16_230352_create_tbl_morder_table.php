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
        Schema::create('tbl_morder', function (Blueprint $table) {
           $table->id();
           $table->string('customer_id', 100);
            // $table->unsignedBigInteger('customer_id');
            $table->enum('order_type', ['delivery', 'pickup'])->default('delivery');
            $table->text('delivery_address')->nullable();
            $table->decimal('service_charge', 10, 2)->default(0);
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_type', ['card', 'cash']);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('status', ['new', 'on_the_way', 'completed', 'cancelled'])->default('new');
            $table->unsignedBigInteger('delivery_boy_id')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_morder');
    }
};
