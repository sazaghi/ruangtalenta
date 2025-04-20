<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelectionMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('selection_methods')->insert([
            ['name' => 'CV'],
            ['name' => 'Aplications letter'],
            ['name' => 'Interview'],
            ['name' => 'Test'],
        ]);
    }
}
