<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkSchedule;

class WorkScheduleSeeder extends Seeder
{
    public function run()
    {
        $jadwal = [
            ['day' => 'Senin', 'start_time' => '08:00:00', 'end_time' => '17:00:00'],
            ['day' => 'Selasa', 'start_time' => '08:00:00', 'end_time' => '17:00:00'],
            ['day' => 'Rabu', 'start_time' => '08:00:00', 'end_time' => '17:00:00'],
            ['day' => 'Kamis', 'start_time' => '08:00:00', 'end_time' => '17:00:00'],
            ['day' => 'Jumat', 'start_time' => '08:00:00', 'end_time' => '17:00:00'],
            ['day' => 'Sabtu', 'start_time' => '08:00:00', 'end_time' => '12:00:00'],
            ['day' => 'Minggu', 'start_time' => null, 'end_time' => null],
        ];

        foreach ($jadwal as $hari) {
            WorkSchedule::create($hari);
        }
    }
}
