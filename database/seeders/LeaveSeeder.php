<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Leave;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class LeaveSeeder extends Seeder
{
    public function run()
    {
        $users = User::take(14)->get();

        foreach ($users as $user) {
            $startDate = Carbon::now()->addDays(rand(1, 30));
            $endDate = (clone $startDate)->addDays(rand(1, 5));

            $reasons = [
                'Sakit dan butuh istirahat',
                'Ada keperluan keluarga',
                'Menghadiri acara penting',
                'Perjalanan pribadi',
                'Butuh waktu untuk menyelesaikan urusan pribadi',
                'Mengurus administrasi penting',
                'Cuti tahunan',
                'Mengikuti pelatihan atau seminar',
                'Istirahat dan mengembalikan energi',
                'Perlu waktu untuk penyembuhan',
                'Mengunjungi keluarga di luar kota',
                'Mengatasi masalah kesehatan mendadak',
                'Kebutuhan pribadi mendesak',
                'Istirahat setelah pekerjaan intensif',
            ];

            Leave::create([
                'user_id' => $user->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'type' => Arr::random(['sick', 'annual', 'personal', 'other']),
                'reason' => Arr::random($reasons),
                'status' => Arr::random(['pending', 'approved', 'rejected']),
            ]);
        }
    }
}
