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
        Schema::create('user_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_name');       // Judul/penamaan file oleh user
            $table->string('file_path');       // Path file di storage
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_uploads');
    }
};
