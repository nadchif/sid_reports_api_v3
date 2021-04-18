<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = json_decode(file_get_contents(__DIR__ . '/system.json'), 1)[2]['data'];
        foreach ($entries as $entry) {
            DB::table('settings')->insert([
                'name' => $entry['profile'],
                'admin_email' => $entry['receiving_email'],
                'allow_signup' => $entry['user_signup'],
                'user_assistance_email' => $entry['user_assist']
            ]);
        }
    }
}
