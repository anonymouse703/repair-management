<?php

use App\Enums\Inventory\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('sku')->unique();
            $table->string('category');
            $table->string('unit')->default(Unit::Piece);
            $table->integer('quantity')->default(0);
            $table->integer('reorder_level')->default(0);
            $table->decimal('cost', 12, 2)->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->string('location')->nullable();
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
