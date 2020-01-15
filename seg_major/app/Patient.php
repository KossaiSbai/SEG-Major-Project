<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    protected $primaryKey = 'patient_id';


    /**
     * @return \Illuminate\Support\Collection
     */
    public function getPatientsOver12()
    {
        $patients = DB::table('patients')->get();
        $ages = $patients->reject(function ($patient) {
            return $this->getAge($patient->date_of_birth) < 12;})
            ->map(function ($patient)
            {
                return $patient;
            });
        return $ages;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    function getOrderedTestDates(){
        $ordered_tests = DB::table('patients')
            ->select ('*')
            ->orderBy('test_date')
            ->get()

        ;
        return $ordered_tests;
    }

    /**
     * @return array
     */
    public function getPatientsUnder12()
    {
        $patients = DB::table('patients')->get();
        $patientsUnder12 = $patients->filter(function($patient) {
            return $this->getAge($patient->date_of_birth) < 12;

        });
        return $patientsUnder12->all();
    }

    /**
     * @return array
     */
    public function getComplexPatients(){
        $patients = DB::table('patients')->get();
        $complexPatients = $patients->filter(function($patient){
           return $patient->is_complex == 'yes';
        });
        return $complexPatients->all();
    }

    /**
     * @return array
     */
    public function getOverdueComplex(){
        $patients = DB::table('patients')->get();
        $complexPatients = $patients->filter(function($patient){
            return date_create('today') > date_create($patient->test_date) && $patient->is_complex == 'yes';
        });
        return $complexPatients->all();
    }


    /**
     * @return array
     */
    public function getOverdue()
    {
        $patients = DB::table('patients')
            ->orderBy('test_date', 'desc')
            ->get();
        $unreviewedPatients = $patients->filter(function($patient) {
            return date_create('today') > date_create($patient->test_date);

        });
        return $unreviewedPatients->all();
    }

    /**
     * @return array
     */
    public function getOverdueUnder12()
    {
        $patients = DB::table('patients')
            ->orderBy('test_date', 'desc')
            ->get();
        $unreviewedPatients = $patients->filter(function($patient) {
            return date_create('today') > date_create($patient->test_date) && $this->getAge($patient->date_of_birth) < 12;

        });
        return $unreviewedPatients->all();
    }

    /**
     * @return array
     */
    public function getOverdueOver12()
    {
        $patients = DB::table('patients')
            ->orderBy('test_date', 'desc')
            ->get();
        $unreviewedPatients = $patients->filter(function($patient) {
            return date_create('today') > date_create($patient->test_date) && $this->getAge($patient->date_of_birth) > 12;

        });
        return $unreviewedPatients->all();
    }

    /**
     * @return array
     */
    public function getAllTestUnder12(){
        $patients = DB::table('patients')->get();
        $allTestUnder = $patients->filter(function($patient){
            return $this->getAge($patient->date_of_birth) < 12;
        });
        return $allTestUnder->all();
    }

    /**
     * @return array
     */
    public function getAllTestOver12(){
        $patients = DB::table('patients')->get();
        $allTestOver = $patients->filter(function($patient){
            return $this->getAge($patient->date_of_birth) > 12;
        });
        return $allTestOver->all();
    }

    /**
     * @return array
     */
    public function getAllTestComplex(){
        $patients = DB::table('patients')->get();
        $allTestComplex = $patients->filter(function($patient){
            return $patient->is_complex == 'yes';
        });
        return $allTestComplex->all();
    }

    /**
     * @param $DOB
     * @return int
     */
    public function getAge($DOB)
    {
        return date_diff(date_create($DOB), date_create('today'))->y;
    }

    /**
     * @param $patient_id
     */
    public function erase($patient_id)
    {
        DB::delete('delete from patients where patient_id = ?', [$patient_id]);
    }



}
