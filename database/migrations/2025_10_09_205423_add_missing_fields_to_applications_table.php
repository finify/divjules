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
        Schema::table('applications', function (Blueprint $table) {
            // Rename country_of_residence to country
            $table->renameColumn('country_of_residence', 'country');

            // Add missing fields
            $table->text('previous_education')->nullable()->after('course_id');
            $table->string('english_proficiency')->nullable()->after('english_test_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->renameColumn('country', 'country_of_residence');
            $table->dropColumn(['previous_education', 'english_proficiency']);
        });
    }
};
