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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('level', ['undergraduate', 'postgraduate', 'diploma', 'certificate'])->default('undergraduate');
            $table->string('duration'); // e.g., "3 years", "18 months"
            $table->decimal('tuition_fee', 10, 2)->nullable();
            $table->string('currency')->default('USD');
            $table->date('intake_start')->nullable();
            $table->date('intake_end')->nullable();
            $table->json('entry_requirements')->nullable(); // Array of requirements
            $table->string('mode_of_study')->nullable(); // Full-time, Part-time, Online
            $table->json('career_prospects')->nullable(); // Array of career paths
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
