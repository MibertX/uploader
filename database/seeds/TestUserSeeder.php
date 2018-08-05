<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => str_random(10),
            'email' => 'admin@test.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
