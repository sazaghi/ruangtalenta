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
        Schema::create('job_selection_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_kerja_id')->constrained()->onDelete('cascade');
            $table->string('selection_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_selection_steps');
    }
};
