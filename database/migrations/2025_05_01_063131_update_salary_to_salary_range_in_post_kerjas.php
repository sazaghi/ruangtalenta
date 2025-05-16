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
        Schema::table('post_kerjas', function (Blueprint $table) {
            $table->dropColumn('salary');
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
        });
    }

    public function down()
    {
        Schema::table('post_kerjas', function (Blueprint $table) {
            $table->dropColumn(['salary_min', 'salary_max']);
            $table->integer('salary')->nullable(); // kembalikan jika rollback
        });
    }

};
