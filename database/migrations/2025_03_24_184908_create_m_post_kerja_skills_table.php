<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('m_post_kerja_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_kerjas_id')->constrained('post_kerjas')->onDelete('cascade');
            $table->text('required_skills'); // JSON atau teks berisi skill yang dibutuhkan
            $table->integer('min_experience')->default(0); // Minimal pengalaman kerja (tahun)
            $table->string('education_level'); // Pendidikan minimal
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_requirements');
    }
};
