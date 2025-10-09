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
        Schema::create('contact_details', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g., 'email', 'phone', 'address'
            $table->string('label'); // e.g., 'Email Address', 'Phone Number'
            $table->text('value'); // The actual contact value
            $table->string('icon')->nullable(); // Icon name for frontend display
            $table->string('type')->default('text'); // text, email, phone, url, address
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_details');
    }
};
