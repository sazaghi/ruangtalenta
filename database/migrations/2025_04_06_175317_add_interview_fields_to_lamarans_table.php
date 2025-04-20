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
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dateTime('tanggal_interview')->nullable();
            $table->string('link_meet')->nullable();
        });
    }

    public function down()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_interview', 'link_meet']);
        });
    }
};
