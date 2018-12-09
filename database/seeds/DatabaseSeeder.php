<?php

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
        //$this->call(UserTableSeeder::class);  // Users 라고 되어 있는데 User~~~로 이름 만들었으니 바꾸자
        //$this->call(BoardTableSeeder::class);
        $this->call(CommentTableSeeder::class);
    }
}
