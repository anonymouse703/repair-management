<?php

use App\Enums\JobOrderService\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_order_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id')->constrained('job_orders')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price', 12, 2)->default(0);
            $table->string('status')->default(Status::Pending);
            $table->timestamps();
            $table->unique([
                'job_order_id',
                'service_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_order_service');
    }
};
