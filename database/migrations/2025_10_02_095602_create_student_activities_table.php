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
        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->morphs('activity_lesson');
            $table->enum('status', ['unfinished', 'finished'])->default('unfinished');
            $table->timestamps();
            $table->unique(
                ['student_id', 'activity_lesson_id', 'activity_lesson_type'],
                'student_act_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_activities');
    }
};
