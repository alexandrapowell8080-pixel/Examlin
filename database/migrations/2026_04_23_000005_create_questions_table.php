<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_name_id')->constrained('exam_names')->onDelete('cascade');
            $table->text('extract')->nullable();
            $table->text('question');
            $table->string('slug', 255)->unique();
            $table->text('choiceA')->nullable();
            $table->text('choiceB')->nullable();
            $table->text('choiceC')->nullable();
            $table->text('choiceD')->nullable();
            $table->text('choiceE')->nullable();
            $table->text('choiceF')->nullable();
            $table->text('choiceG')->nullable();
            $table->string('correctAnswer', 500);
            $table->text('rationale')->nullable();
            $table->string('image', 1500)->nullable();
            $table->string('qtype', 255)->default('Regular');
            $table->text('heading')->nullable();
            $table->string('resource_url', 500)->default('https://examlin.com');
            $table->string('added_by', 100)->default('admin');
            $table->timestamp('date_added')->useCurrent();
            
            $table->primary('id');
            $table->unique(['slug'], 'uk_question_slug');
            $table->index('exam_name_id', 'fk_question_examname');
        }, 'utf8mb4', 'utf8mb4_general_ci');
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};