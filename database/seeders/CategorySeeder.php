<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'IT & Software',
            'Finance',
            'Marketing',
            'Management & Business',
            'Education',
            'Design & Creativity'
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
