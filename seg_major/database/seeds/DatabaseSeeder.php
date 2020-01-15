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
        \Illuminate\Database\Eloquent\Model::unguard();

        $this->call(HospitalTableSeeder::class);
        $this->call(PatientTableSeeder::class);

        // Re enable all mass assignment restrictions
        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
