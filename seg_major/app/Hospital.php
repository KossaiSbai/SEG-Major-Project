<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hospital extends Model
{
    protected $primaryKey = 'hospital_id';

    /**
     * @return \Illuminate\Support\Collection
     */
    function getOrderedHospitals(){
        $ordered_hospitals = DB::table('hospitals')
            ->select ('hospitals.hospital_id', 'hospitals.name')
            ->orderBy('hospitals.name')
            ->get()

        ;
        return $ordered_hospitals;
    }
}
