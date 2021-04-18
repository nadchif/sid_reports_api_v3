<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(__DIR__ . "/conferences.csv", "r");
        while (! feof($file)) {
            $csvData = (fgetcsv($file));
            if (is_array($csvData)) {
                $id = $csvData[0];
                $name = $csvData[1];
                $address = $csvData[2];
                $created = $csvData[3];
                $phone = intval($csvData[4]);
                $code = $csvData[7];
                $old_id = $csvData[6];
                $db_union = DB::table('unions')->where('v2id', $old_id)->first();
                $union_id = $db_union->id;
                
                DB::table('conferences')->insert([
                    'name' => $name,
                    'union_id'=>$union_id,
                    'address' => $address,
                    'code' => $code,
                    'created_at'=>$created,
                    'updated_at'=>$created,
                    'phone'=>$phone,
                    'v2id'=>$id
                ]);
            }
        }
    }
}
