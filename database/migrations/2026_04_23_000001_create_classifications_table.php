<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->timestamp('created_at')->useCurrent();
            
            $table->primary('id');
            $table->unique(['name'], 'uk_classification_name');
        }, 'utf8mb4', 'utf8mb4_general_ci');
    }

    public function down(): void
    {
        Schema::dropIfExists('classifications');
    }
};