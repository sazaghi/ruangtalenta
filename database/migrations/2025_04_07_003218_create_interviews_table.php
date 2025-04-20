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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_kerjas_id')->constrained()->onDelete('cascade');
            $table->string('tipe'); // misal: 'Tes Wawancara' / 'Tes Teknikal'
            $table->string('metode'); // misal: 'Online via Zoom'
            $table->dateTime('jadwal');
            $table->string('link')->nullable(); // misal: link Zoom
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
