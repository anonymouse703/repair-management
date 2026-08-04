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
        Schema::create('job_order_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('inventory_item_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('technician_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('cost_at_time', 12, 2);
            $table->decimal('price_at_time', 12, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_order_inventories');
    }
};
