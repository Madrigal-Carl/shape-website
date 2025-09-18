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
        Schema::create('activity_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('activity_lessonable_type');
            $table->unsignedBigInteger('activity_lessonable_id');
            $table->timestamps();
            $table->index(
                ['activity_lessonable_type', 'activity_lessonable_id'],
                'activity_lessonable_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_lessons');
    }
};
