<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Hospital;
use Illuminate\Support\Facades\DB;

class HospitalUnitTest extends TestCase
{
    use RefreshDatabase;
    public function create_hospital()
    {
        $hospital = factory(Hospital::class)->make();
        DB::table('hospitals')->insert([
            'hospital_id' => $hospital->hospital_id,
            'name' =>$hospital->name,
        ]);
        return $hospital;
    }

    /**
     * @test
     */
    public function getOrderedHospitalsTest()
    {
        $hospitalModel = new Hospital();
        foreach (range(0,4) as $i) {
            $hospital = $this->create_hospital();
        }
        $orderedHospitals = $hospitalModel->getOrderedHospitals();
        $orderedHospitals2 = DB::table('hospitals')->orderBy('name')->get();
        foreach (range(0,$orderedHospitals->count()-1) as $index)
        {
            $this->assertEquals($orderedHospitals[$index]->name,$orderedHospitals2[$index]->name);
        }
    }

}
