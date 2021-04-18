<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(SettingsSeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(UnionSeeder::class);
        $this->call(ConferenceSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(ChurchSeeder::class);
        $this->call(FormSeeder::class);
        $this->call(ResponseSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(TransferRequestSeeder::class);
        $this->call(UserSeeder::class);
    }
}
