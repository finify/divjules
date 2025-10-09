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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_number')->unique();
            $table->foreignId('application_stage_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('university_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country_of_residence')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();

            // Academic Information
            $table->string('highest_qualification')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('graduation_year')->nullable();
            $table->string('gpa')->nullable();

            // English Proficiency
            $table->string('english_test_type')->nullable();
            $table->string('english_test_score')->nullable();

            // Additional Information
            $table->text('statement_of_purpose')->nullable();
            $table->text('notes')->nullable();
            $table->json('form_data')->nullable(); // Store complete form data as JSON

            // Application Status
            $table->string('status')->default('pending'); // pending, processing, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
