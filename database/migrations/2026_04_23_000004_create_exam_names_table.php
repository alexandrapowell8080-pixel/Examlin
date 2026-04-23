<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_names', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->timestamp('created_at')->useCurrent();
            
            $table->primary('id');
            $table->unique(['exam_id', 'name'], 'uk_examname_name');
            $table->unique(['slug'], 'uk_examname_slug');
        }, 'utf8mb4', 'utf8mb4_general_ci');
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_names');
    }
};