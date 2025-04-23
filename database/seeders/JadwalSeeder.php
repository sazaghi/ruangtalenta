<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        Jadwal::create([
            'title' => 'Tes Wawancara',
            'date' => '2025-03-31',
            'time' => '07:15 am - 10:45 am',
            'link' => 'https://www.figma.com/design/yZ4voXnfFcBKcA1k9hgApA/wire-frame?node-id=436-7715',
            'note' => 'Busy',
            'status' => 'On Progress',
            'status_icon' => '🔴',
        ]);

        Jadwal::create([
            'title' => 'Tes Tertulis',
            'date' => '2025-03-31',
            'time' => '11:15 am - 13:45 pm',
            'link' => 'https://www.figma.com/design/yZ4voXnfFcBKcA1k9hgApA/wire-frame?node-id=436-7715',
            'note' => 'Busy',
            'status' => 'On Progress',
            'status_icon' => '🔴',
        ]);

        Jadwal::create([
            'title' => 'Tes Wawancara',
            'date' => '2025-03-31',
            'time' => '07:15 am - 10:45 am',
            'link' => 'https://www.figma.com/design/yZ4voXnfFcBKcA1k9hgApA/wire-frame?node-id=436-7715',
            'note' => 'Busy',
            'status' => 'On Progress',
            'status_icon' => '🔴',
        ]);
    }
}
