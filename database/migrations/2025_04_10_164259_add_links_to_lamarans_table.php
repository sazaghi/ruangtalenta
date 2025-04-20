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
            $table->text('interview_link')->nullable();
            $table->text('test_link')->nullable();
        });
    }

    public function down()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dropColumn(['interview_link', 'test_link']);
        });
    }
};
