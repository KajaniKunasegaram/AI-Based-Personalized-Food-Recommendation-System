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
        Schema::create('tbl_delivery_boys', function (Blueprint $table) {
            $table->id();                 // Primary key
            $table->string('name');       // Delivery boy name
            $table->string('phone');      // Phone number
            $table->timestamps();         // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_delivery_boys');
    }
};
