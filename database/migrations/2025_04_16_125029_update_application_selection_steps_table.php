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
        Schema::table('application_selection_steps', function (Blueprint $table) {
            $table->string('title')->nullable()->after('job_selection_step_id');
            $table->enum('type', ['Test', 'Interview'])->default('Test')->after('title');
            $table->text('notes')->nullable()->after('link');
            $table->text('result_note')->nullable()->after('status');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
