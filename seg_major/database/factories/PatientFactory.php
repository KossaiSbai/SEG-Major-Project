<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB as DB;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Patient::class, function (Faker $faker) {
    $fullname = $faker->name;
    $ids = DB::table('hospitals')->get('hospital_id')->toArray();
    $hospital_id =$ids[array_rand($ids)]->hospital_id;
    $sex = (float)rand() / (float)getrandmax() < 0.5 ? "male" : "female";
    $complex = (float)rand() / (float)getrandmax() < 0.5 ? "yes" : "no";
    return [
        'patient_id' => $faker->numberBetween(1000,10000),
        'forename' =>explode(' ',$fullname,2)[0],
        'surname' => explode(' ',$fullname,2)[1],
        'date_of_birth'=>$faker->date(),
        'internal_id' => $faker->numberBetween(1000,10000),
        'sex' => $sex,
        'email' => $faker->safeEmail,
        'hospital'=>$hospital_id,
        'test_date'=>$faker->date(),
        'is_complex' => $complex,

    ];
});
