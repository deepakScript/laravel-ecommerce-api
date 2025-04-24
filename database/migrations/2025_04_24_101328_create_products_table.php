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
        
            // foreign keys (column + FK in one shot)
            $table->foreignId('category_id')
                  ->constrained('category')   // assumes table name is categories
                  ->cascadeOnDelete();
        
            $table->foreignId('brand_id')
                  ->constrained('brands')       // change to your actual brands table
                  ->cascadeOnDelete();
        
            $table->string('name');
            $table->boolean('is_trendy')->default(false);
        
            // typo fixed: is_available
            $table->boolean('is_available')->default(true);
        
            $table->decimal('price', 8, 2);
            $table->integer('amount');
            $table->decimal('discount', 8, 2)->nullable();
            $table->string('image');
        
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
