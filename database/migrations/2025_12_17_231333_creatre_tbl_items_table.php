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
        Schema::create('tbl_items', function (Blueprint $table) {
            $table->increments('item_id');
            $table->unsignedInteger('sub_cat_id');
            $table->string('item_name');
            $table->text('item_description')->nullable();
            $table->decimal('item_price', 8, 2);
            $table->string('item_image')->nullable();
            $table->boolean('item_status')->default(1);
            $table->timestamps();

            $table->foreign('sub_cat_id')
                ->references('sub_cat_id')
                ->on('tbl_sub_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::dropIfExists('tbl_items');
    }
};
