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
        Schema::create('job_order_release_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('released_by')
                ->constrained('users');

            $table->decimal('balance_at_release', 12, 2);

            $table->text('reason')->nullable();

            $table->timestamp('released_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_order_release_logs');
    }
};
