<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->timestamp('created_at')->useCurrent();
            
            $table->primary('id');
            $table->unique(['category_id', 'name'], 'uk_exam_name');
            $table->unique(['slug'], 'uk_exam_slug');
        }, 'utf8mb4', 'utf8mb4_general_ci');
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};