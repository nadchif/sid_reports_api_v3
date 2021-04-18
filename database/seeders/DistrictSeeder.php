<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(__DIR__ . "/districts.csv", "r");
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
                
                echo "\nDistrict: ".$name;
                DB::table('districts')->insert([
                    'name' => $name,
                    'conference_id'=>$conference_id,
                    'address' => $address,
                    'created_at'=>$created,
                    'updated_at'=>$created,
                    'phone'=>$phone,
                    'v2id'=>$id
                ]);
            }
        }
        $db_conference = DB::table('conferences')->get();
        foreach($db_conference as $conference){
            DB::table('districts')->insert([
                'name' => 'Unlisted/Not Applicable',
                'conference_id'=>$conference->id,
                'address' => $conference->address,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'phone'=>0,
                'v2id'=>null
            ]);
        }
        
    }
}
