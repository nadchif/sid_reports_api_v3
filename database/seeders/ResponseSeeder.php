<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = json_decode(file_get_contents(__DIR__ . '/responses.json'), 1)[2]['data'];
        file_put_contents(__DIR__ . '/responses.log', '');
        foreach ($entries as $entry) {
            $id = $entry['id'];

            $category = $entry['org_category'];
            if ($category == 'user') $category = 'church';
            if ($category == 'conf') $category = 'conference';
            $author = $entry['user'] == 'admin' ? 'admin@domain.com' : $entry['user'] ;
            

            $db_user = DB::table('users')->where('email', $author)->first();
            if(!$db_user){
                echo '\nSKIPPED:'. $entry['user'];
                file_put_contents(__DIR__ . '/responses.log', (date('Y-m-d H:i:s') . " SKIPPED: ". $entry['user'] . PHP_EOL), FILE_APPEND );
                continue;
            }
            
            echo "\nResponse: " . $entry['user'];
            $user_id = $db_user->id;
            $form_id = DB::table('forms')->where('slug', $entry['form'])->first()->id;

            DB::table('responses')->insert([
                'user_id' => $user_id,
                'form_id' => $form_id,
                'period' => $entry['period'],
                'item' => $entry['question'],
                'source' => $category, // conference / church
                'org_id' => $entry['org_id'],
                'created_at' => $entry['created'],
                'updated_at' => $entry['updated'],
                'data' => $entry['response'],
                'v2id' => $id
            ]);
        }
    }
}
