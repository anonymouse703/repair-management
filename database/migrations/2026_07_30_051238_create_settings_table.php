<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->enum('scope', ['system', 'app', 'admin'])->default('system');
            $table->string('label');
            $table->text('description')->nullable();
            $table->enum('type', ['boolean', 'text', 'select', 'integer', 'float', 'datetime', 'json']);
            $table->text('options')->nullable();
            $table->boolean('is_readonly')->default(false);
             $table->bigInteger('created_ts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
