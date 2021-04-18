<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = json_decode(file_get_contents(__DIR__ . '/forms.json'), 1)[2]['data'];
        foreach($entries as $entry){
        
                $id = $entry['id'];
                $title = $entry['title'];
                $description = $entry['description'];
                $cycle = $entry['access_cycle'];
                $restrict_to = $entry['access_policy'];
                $created = $entry['created'];
                $slug = $entry['url_ref'];
                $active = $entry['active'];
                $author = $entry['author'];
                $raw_items = json_decode($entry['items'], 1);
                $item = $raw_items;
                foreach($raw_items as $item){
                    if(!is_array($item['options'])){
                        $item['options'] = json_decode($item['options']);
                    }
                }
                $items = json_encode($item);
                if($author == 'admin')$author = 'admin@domain.com';
                echo $author;
                $db_author = DB::table('users')->where('email', $author)->first();
                $user_id = $db_author->id;

                echo "\nForm: ".$title;
                DB::table('forms')->insert([
                    'title' => $title,
                    'description'=>$description,
                    'cycle' => $cycle,
                    'created_at'=>$created,
                    'updated_at'=>$created,
                    'restrict_to'=>$restrict_to,
                    'slug'=>$slug,
                    'active'=>$active,
                    'user_id'=>$user_id,
                    'items'=>$items,
                    'v2id'=>$id
                ]);
                }
        
    }
}
