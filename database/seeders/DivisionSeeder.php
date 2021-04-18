<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('divisions')->insert([
            'id'=>1,
            'name' => 'Southern Africa-Indian Ocean Division',
            'created_at'=>date('Y-m-d H:i:s'),           
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
    }
}
