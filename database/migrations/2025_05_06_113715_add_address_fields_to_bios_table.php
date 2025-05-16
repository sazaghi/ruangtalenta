<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bios', function (Blueprint $table) {
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('complete_address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bios', function (Blueprint $table) {
            $table->dropColumn(['country', 'city', 'complete_address']);
        });
    }

};
