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
        Schema::create('tbl_item_modifier_group', function (Blueprint $table) {
           
             $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('modifier_group_id');

            $table->primary(['item_id','modifier_group_id']);

            $table->foreign('item_id')
                  ->references('item_id')->on('tbl_items')
                  ->onDelete('cascade');

            $table->foreign('modifier_group_id')
                  ->references('id')->on('tbl_modifiers_group')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_item_modifier_group');
    }
};
