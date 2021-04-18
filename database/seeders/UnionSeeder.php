<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(__DIR__ . "/unions.csv", "r");

        while (! feof($file)) {
            $csvData = (fgetcsv($file));
            if (is_array($csvData)) {
                $id = $csvData[0];
                $name = $csvData[1];
                $address = $csvData[2];
                $created = $csvData[3];
                $phone = intval($csvData[4]);
                $code = $csvData[6];

                DB::table('unions')->insert([
                    'name' => $name,
                    'division_id'=>1,
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
