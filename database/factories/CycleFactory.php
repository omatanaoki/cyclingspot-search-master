<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Cycle;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Cycle::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'content' => $faker->text(140),
        'title' => $faker->text(15),
        'area' => '神奈川',
        'city' => $faker->randomElement(['横浜市', '川崎市', '相模原市', '横須賀市','平塚市', '鎌倉市','藤沢市',
        '小田原市', '茅ヶ崎市','逗子市','三浦市','秦野市','厚木市','大和市', '伊勢原市','海老名市','座間市', '南足柄市', '綾瀬市', 
        '葉山町','寒川町', '大磯町','二宮町', '中井町','大井町','松田町','山北町', '開成町','箱根町', '真鶴町','湯河原町',
        '愛川町', '清川村']),
        'location' => $faker->text(15),
        'lat' => $faker->latitude(),
        'lng' => $faker->longitude(),
    ];
});