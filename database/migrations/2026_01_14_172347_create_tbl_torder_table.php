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
        Schema::create('tbl_torder', function (Blueprint $table) {
               $table->id(); // ✅ FIXED
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('item_id');
            $table->string('item_name');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->json('modifiers')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                  ->references('id')
                  ->on('tbl_morder')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_torder');
    }
};
