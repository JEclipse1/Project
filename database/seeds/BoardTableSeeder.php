<?php

use Illuminate\Database\Seeder;

class BoardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Board::class, 100)->create();  // User에서 유저 랜덤으로 만들어준 것 처럼 게시글(Board)도 랜덤으로 만들어보자
    }
}
