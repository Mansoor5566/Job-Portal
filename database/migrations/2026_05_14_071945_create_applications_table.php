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
            $table->foreignId('job_id')->constrained('job_listings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // seeker
            $table->text('cover_letter')->nullable();
            $table->string('resume')->nullable(); // uploaded at apply time
            $table->enum('status', ['applied', 'viewed', 'shortlisted', 'rejected', 'hired'])->default('applied');
            $table->timestamps();
            $table->unique(['job_id', 'user_id']); // prevent duplicate applications
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
