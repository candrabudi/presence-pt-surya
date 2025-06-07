<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::create([
            'company_name' => 'PT Surya Pelangi Nusantara Sejahtera',
            'company_logo' => null,
            'address' => 'Jl. Raya Industri No.123, Jakarta, Indonesia',
            'phone' => '021-12345678',
            'email' => 'info@suryapelangi.co.id',
            'default_check_in' => '08:00:00',
            'default_check_out' => '17:00:00',
            'footer_text' => '© 2025 PT Surya Pelangi Nusantara Sejahtera. Semua hak dilindungi.',
        ]);
    }
}
