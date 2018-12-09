<?php

use Faker\Generator as Faker;
use App\User;   // 밑에 App\User::min 이런식으로 쓰기 싫으면 use로 작성해주자.

$factory->define(App\Board::class, function (Faker $faker) {
    $minId = User::min('id');   // User 테이블에 min값 id 가져와줘  -> select min(id) from users;
    $maxId = User::max('id');   // User 테이블에 max값 id 가져와줘  -> select max(id) from users;
    return [
        //
        'title'=>$faker->word(20),
        'content'=>$faker->sentence,
        //'user_id'=>nummberBetween(1, 12)  // 1~12 까지의 id값 가져오자.. 근데 이렇게 하면 id값은 언제든지 변동 될 수 있으니 바람직 하지 않다..
        'user_id'=>$faker->numberBetween($minId, $maxId),  // 이렇게 해주는 이유는 ?? Id는 언제든지 변할 수 있으니 가장 작은값에서 큰 값까지..
    ];
});
