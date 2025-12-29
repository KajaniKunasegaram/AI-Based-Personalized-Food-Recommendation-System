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
        Schema::create('tbl_modifiers', function (Blueprint $table) {
        
            $table->id();

            $table->foreignId('modifier_group_id')
                ->constrained('tbl_modifiers_group')
                ->cascadeOnDelete();

            $table->string('name');
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('min')->default(0);
            $table->integer('max')->default(0);
            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_modifiers');
    }
};
