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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('discription');
            $table->decimal('price',10,2);
            $table->integer('quantity')
            ->default(0);
             $table->integer('min_quantity_alert')
            ->default(5);
            $table->text('image_url');
            $table->foreignId('admins_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('categories_id')
            ->constrained()
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
