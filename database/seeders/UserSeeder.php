<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Default',
            'last_name' => 'Admin',
            'email' => 'admin@domain.com',
            'category' => 'admin',
            'org_id' => 0,
            'phone' => 0,
            'address' => '',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => password_hash(Str::random(8), PASSWORD_DEFAULT)
        ]);

        $entries = json_decode(file_get_contents(__DIR__ . '/members.json'), 1)[2]['data'];
        foreach ($entries as $entry) {
            $id = $entry['id'];
            $org_id = null;
            switch ($entry['usercat']) {
                case 'admin':
                    $org_id = 0;
                    break;
                case 'union':
                    $org_id = DB::table('unions')->where('v2id', $entry['org'])->first()->id;
                    break;
                case 'conf':
                    $org_id = DB::table('conferences')->where('v2id', $entry['org'])->first()->id;
                    break;
                case 'dist':
                    $org_id = DB::table('districts')->where('v2id', $entry['org'])->first()->id;
                    break;
                case 'user':
                    $org_id = DB::table('churches')->where('v2id', $entry['org'])->first()->id;
                    break;
                default:
                    $org_id = null;
            }
            $category = $entry['usercat'];
            if ($category == 'user') $category = 'church';
            if ($category == 'dist') $category = 'district';
            if ($category == 'conf') $category = 'conference';


            echo "\nUser: " . $entry['email'];
            DB::table('users')->insert([
                'first_name' => $entry['fname'],
                'last_name' => $entry['lname'],
                'email' => $entry['email'],
                'category' => $category,
                'org_id' => $org_id,
                'phone' => $entry['contactno'],
                'address' => $entry['contactad'],
                'blocked' => $entry['blocked'],
                'send_notifications' => $entry['notis_email'],
                'email_verified_at' => $entry['verified'] == 1 ? $entry['mod_timestamp'] : null,
                'password' => $entry['password'],
                'v2id' => $id
            ]);
        }
    }
}
