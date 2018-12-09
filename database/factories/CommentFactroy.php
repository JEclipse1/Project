<?php

use Faker\Generator as Faker;
use App\User;
use App\Board;

$factory->define(App\Comment::class, function (Faker $faker) {
    $minId = User::min('id');   // User 테이블에 min값 id 가져와줘  -> select min(id) from users;
    $maxId = User::max('id');

    $minId_board = Board::min('id');   // User 테이블에 min값 id 가져와줘  -> select min(id) from users;
    $maxId_board = Board::max('id');
    return [
        //
        'content'=>$faker->sentence,
        'board_id'=>$faker->numberBetween($minId_board, $maxId_board),
        'user_id'=>$faker->numberBetween($minId, $maxId),
    ];
});
