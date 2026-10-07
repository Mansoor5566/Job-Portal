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
    Schema::create('job_listings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description');
        $table->string('location');
        $table->boolean('is_remote')->default(false);
        $table->enum('job_type', ['full-time','part-time','contract','internship','freelance']);
        $table->string('experience_level');
        $table->decimal('salary_min', 10, 2)->nullable();
        $table->decimal('salary_max', 10, 2)->nullable();
        $table->json('skills_required')->nullable();
        $table->date('deadline')->nullable();
        $table->enum('status', ['active','closed','draft'])->default('active');
        $table->boolean('is_featured')->default(false);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('job_listings');
}
};
