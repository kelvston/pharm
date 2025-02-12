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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');// Staff handling the sale
            $table->integer('medicine_id'); // Sold medicine
            $table->integer('batch_number')->nullable(); // Unique batch number for this sale
            $table->unsignedInteger('quantity'); // Quantity sold
            $table->decimal('total_amount', 10, 2); // Total sale amount
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
