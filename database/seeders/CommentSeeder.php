<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = json_decode(file_get_contents(__DIR__ . '/comments.json'), 1)[2]['data'];
        foreach ($entries as $entry) {
            $id = $entry['id'];

            $category = $entry['level'];
            if ($category == 'user') $category = 'church';
            if ($category == 'conf') $category = 'conference';
            $author = $entry['author'] == 'admin' ? 'admin@domain.com' : $entry['author'] ;
            

            $db_user = DB::table('users')->where('email', $author)->first();
            if(!$db_user){
                echo '\nSKIPPED:'. $entry['author'];
                continue;
            }
            
            echo "\nComment: " . $entry['author'];
            $user_id = $db_user->id;
            $form_id = DB::table('forms')->where('slug', $entry['form'])->first()->id;

            DB::table('comments')->insert([
                'user_id' => $user_id,
                'form_id' => $form_id,
                'period' => $entry['period'],
                'level' => $category, // conference / church
                'org_id' => $entry['orgID'],
                'content' => $entry['data'],
                'v2id' => $id
            ]);
        }
    }
}
