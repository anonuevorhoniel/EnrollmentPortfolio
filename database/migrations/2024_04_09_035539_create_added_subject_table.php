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
        Schema::create('added_subject', function (Blueprint $table) {
            $table->id();
            $table->string('subj_name');
            $table->string('schedule');
            $table->string('year_lvl');
            $table->integer('points');
            $table->string('course');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('added_subject');
    }
};
