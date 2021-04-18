<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransferRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = json_decode(file_get_contents(__DIR__ . '/members.json'), 1)[2]['data'];
        foreach ($entries as $entry) {
            $id = $entry['id'];
            if($entry['review_cat'] == ''){
                continue;
            }
            $org_id = null;
            switch ($entry['review_cat']) {
                case 'admin':
                    $org_id = 0;
                    break;
                case 'union':
                    $org_id = DB::table('unions')->where('v2id', $entry['review_org'])->first()->id;
                    break;
                case 'conf':
                    $org_id = DB::table('conferences')->where('v2id', $entry['review_org'])->first()->id;
                    break;
                case 'dist':
                    $org_id = DB::table('districts')->where('v2id', $entry['review_org'])->first()->id;
                    break;
                case 'user':
                    $org_id = DB::table('churches')->where('v2id', $entry['review_org'])->first()->id;
                    break;
                default:
                    $org_id = null;
            }
            

            $category = $entry['review_cat'];
            if ($category == 'user') $category = 'church';
            if ($category == 'dist') $category = 'district';
            if ($category == 'conf') $category = 'conference';
            $user = $entry['email'];

            if ($user == 'admin') $user = 'admin@domain.com';
            $db_user = DB::table('users')->where('email', $user)->first();
            $user_id = $db_user->id;

            echo "\nTransfer Request: " . $entry['email'];
            DB::table('transfer_requests')->insert([
                'user_id' => $user_id,
                'target_category' => $category,
                'target_org_id' => $org_id,
            ]);
        }
    }
}
