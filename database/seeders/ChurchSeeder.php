<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChurchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(__DIR__ . "/churches.csv", "r");
        while (! feof($file)) {
            $csvData = (fgetcsv($file));
            if (is_array($csvData)) {
                $id = $csvData[0];
                $name = $csvData[1];
                $address = $csvData[2];
                $created = $csvData[3];
                $phone = intval($csvData[4]);
                $old_id = $csvData[6];
                $db_conference = DB::table('conferences')->where('v2id', $old_id)->first();
                $conference_id = $db_conference->id;
                $old_dist_id = $csvData[7];
                $db_district = DB::table('districts')->where('v2id', $old_dist_id)->first();
                
                echo "\nChurch: ".$name;
                if(!isset($db_district->id)){
                    $db_district =  DB::table('districts')
                    ->where('conference_id', $conference_id)
                    ->where('name', 'Unlisted/Not Applicable')
                    ->first();
                }
                $district_id = $db_district->id ;
                
                DB::table('churches')->insert([
                    'name' => $name,
                    'conference_id'=>$conference_id,
                    'district_id'=>$district_id,
                    'address' => $address,
                    'created_at'=>$created,
                    'updated_at'=>$created,
                    'phone'=>$phone,
                    'v2id'=>$id
                ]);
            }
        }
    }
}
