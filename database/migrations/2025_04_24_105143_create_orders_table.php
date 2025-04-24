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
        
            $table->enum('status', [
                'Pending',
                'Accepted',
                'Out of delivery',
                'Delivered',
                'Canceled',
            ])->default('Pending');
        
            // FK to users.id
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
        
            // FK to locations.id  (change table name if different)
            $table->foreignId('location_id')
                  ->constrained('location')    // plural is typical
                  ->cascadeOnDelete();
        
            $table->decimal('total_price', 12, 2);
        
            // use date instead of string if possible
            $table->date('date_of_delivery');
        
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
