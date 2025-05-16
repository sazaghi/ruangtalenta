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
            // Hapus foreign key lama
            $table->dropForeign(['current_stage_id']);

            // Tambahkan foreign key baru ke selection_stages
            $table->foreign('current_stage_id')->references('id')->on('selection_stages')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dropForeign(['current_stage_id']);

            // Kembalikan ke templates jika perlu rollback
            $table->foreign('current_stage_id')->references('id')->on('selection_templates')->nullOnDelete();
        });
    }

};
