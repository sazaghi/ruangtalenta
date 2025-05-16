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
        Schema::create('selection_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lamarans_id')->constrained()->onDelete('cascade');
            $table->string('stage_name');
            $table->enum('status', ['Pending', 'Scheduling', 'Executing', 'Checking_Result', 'Done'])->default('Pending');
            $table->integer('order_index');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selection_stages');
    }
};
