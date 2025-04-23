<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
{
    Schema::create('jadwals', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->date('date');
        $table->string('time'); // atau bisa juga pakai 2 kolom: time_start dan time_end
        $table->text('link');
        $table->string('note')->nullable();
        $table->string('status')->default('On Progress');
        $table->string('status_icon')->default('🔴');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
