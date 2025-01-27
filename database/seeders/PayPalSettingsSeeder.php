<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayPalSettingsSeeder extends Seeder
{
    public function run()
    {
        // Use updateOrCreate to insert or update PayPal settings
        DB::table('paypal_settings')->updateOrInsert(
            ['id' => 1], // Assuming the PayPal settings have an 'id' of 1
            [
                'client_id' => '12',
                'secret' => 'asfd',
                'mode' => 'sandbox', // Use 'live' for production
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}

