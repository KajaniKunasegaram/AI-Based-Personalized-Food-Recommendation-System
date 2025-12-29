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
        Schema::create('tbl_sub_categories', function (Blueprint $table) {
            $table->increments('sub_cat_id');
            $table->unsignedBigInteger('cat_id');
            $table->string('sub_cat_name');
            $table->text('sub_cat_description')->nullable();
            $table->string('sub_cat_image')->nullable();
            $table->boolean('sub_cat_status')->default(true);
            $table->timestamps();

            $table->foreign('cat_id')->references('cat_id')->on('tbl_categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sub_categories');
    }
};
