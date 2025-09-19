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
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('first_quarter_start');
            $table->date('first_quarter_end');
            $table->date('second_quarter_start');
            $table->date('second_quarter_end');
            $table->date('third_quarter_start');
            $table->date('third_quarter_end');
            $table->date('fourth_quarter_start');
            $table->date('fourth_quarter_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_years');
    }
};
