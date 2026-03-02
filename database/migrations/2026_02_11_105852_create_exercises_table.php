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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Cohérence 5-5"
            $table->text('description')->nullable();
            $table->integer('duration_inhale'); // En secondes (ex: 5)
            $table->integer('duration_hold');   // En secondes (ex: 0)
            $table->integer('duration_exhale'); // En secondes (ex: 5)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
