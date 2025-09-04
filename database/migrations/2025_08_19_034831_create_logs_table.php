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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_activity_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('attempt_number')->default(1);
            $table->unsignedInteger('time_spent_seconds');
            $table->enum('status', ['in-progress', 'completed'])->default('in-progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
