<?php

namespace Tests\Feature;

use App\Hospital;
use App\Patient;
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use PHPUnit\Framework\Test;
class PatientUnitTest extends TestCase
{
use RefreshDatabase;



    public function create_hospital()
    {
        $hospital = factory(Hospital::class)->make();
        DB::table('hospitals')->insert([
            'hospital_id' => $hospital->hospital_id,
            'name' =>$hospital->name,
        ]);

    }

    public function generate_patient_data()
    {
        $patient = factory(Patient::class)->make();
        $patient_data = [];
        $patient_data['patient_id'] =  $patient->patient_id;
        $patient_data['forename'] = $patient->forename;
        $patient_data['surname'] =  $patient->surname;
        $patient_data['date_of_birth']= $patient->date_of_birth;
        $patient_data['internal_id'] =  $patient->internal_id;
        $patient_data['sex'] = $patient->sex;
        $patient_data['contact'] = $patient->contact;
        $patient_data['email'] = $patient->email;
        $patient_data['hospital']= $patient->hospital;
        $patient_data['test_date']= $patient->test_date;
        $patient_data['is_complex'] =  $patient->is_complex;
        return $patient_data;
    }

    /**
     * A basic feature test example
     */
    public function create_patient()
    {
        $this->create_hospital();
        $patient_data = $this->generate_patient_data();
        DB::table('patients')->insert($patient_data);
        $patient = DB::table('patients')->get()->first();
        return $patient;

    }

    /**
     * @test
     */
    public function it_can_create_a_patient()
    {
       $patient = $this->create_patient();
       $this->assertDatabaseHas('patients',[
          'forename'=>$patient->forename,
          'surname'=>$patient->surname,
          'internal_id' => $patient->internal_id,
          'patient_id' => $patient->patient_id
       ]);
    }

    /**
     * @test
     */
    public function when_retrieving_a_patient_the_details_are_correct()
    {
        $patient = $this->create_patient();
        $databasePatient = Patient::find($patient->patient_id);
        $this->assertNotNull($databasePatient);
        $this->assertEquals($databasePatient->patient_id,$patient->patient_id);
        $this->assertEquals($databasePatient->forename,$patient->forename);
        $this->assertEquals($databasePatient->surname,$patient->surname);
    }

    /**
     * @test
     */
    public function it_can_update_a_patient()
    {
        $patient = $this->create_patient();
        $patient ->forename = "Alex";
        $patient->is_complex = "yes";
        $patient->test_date = "2019-03-30";
        $this->assertEquals("Alex",$patient->forename);
        $this->assertEquals("yes",$patient->is_complex);
        $this->assertEquals("2019-03-30",$patient->test_date);
    }

    /**
     * @test
     */
    public function it_can_delete_a_patient()
    {
        $patient = $this->create_patient();
        Patient::destroy($patient->patient_id);
        $this->assertDatabaseMissing('patients',[
            'forename' => $patient->forename,
            'surname' => $patient->surname,
            'patient_id'=>$patient->patient_id
        ]);
    }

    /**
     * @test
     * Here the field called patient_id which is the primary key of the patients table is missing.
     */
    public function it_should_throw_an_error_when_the_required_columns_are_not_filled()
    {
        $this->expectException(QueryException::class);
        $wrong_patient_data = [];
        $wrong_patient_data['forename'] = "Kossai";
        $wrong_patient_data['surname'] = "Sbai";
        DB::table('patients')->insert($wrong_patient_data);
    }

    /**
     * @test
     */
    public function it_should_throw_an_error_when_the_required_columns_are_filled_with_wrong_format_values()
    {
        $this->expectException(QueryException::class);
        $wrong_patient_data = [];
        $wrong_patient_data['forename'] = "Kossai";
        $wrong_patient_data['surname'] = "Sbai";
        $wrong_patient_data['test_date'] = 388;
        DB::table('patients')->insert($wrong_patient_data);
    }

    /**
     * @test
     */
    public function it_should_throw_an_error_when_the_patient_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);
        $patient = $this->create_patient();
        $requiredPatient = Patient::findOrFail(2000);
    }

    /**
     * @test
     */

    public function set_a_non_nullable_attribute_to_null_should_throw_an_error_and_not_update_the_attribute()
    {
        $this->expectException(QueryException::class);
        $patient = $this->create_patient();
        DB::table('patients')
            ->where('patient_id', $patient->patient_id)
            ->update(array('date_of_birth' => null));
        $this->assertNotNull($patient->date_of_birth);
    }


    /**
     * @test
     */
    public function set_an_attribute_to_a_value_with_a_wrong_format_should_thrown_an_error_and_not_update_the_attribute()
    {
        $this->expectException(QueryException::class);
        $patient = $this->create_patient();
        $data = array('test_date' => 478987899843268914);
        DB::table('patients')
            ->where('patient_id', $patient->patient_id)
            ->update($data);
       $this->assertNotEquals($data['test_date'],$patient->test_date);
   }

   /**
    * @test
    */
   public function attempting_to_delete_a_non_existing_patient_fails()
   {
       $delete = DB::table('patients')->where('patient_id','=',10000)->delete();
       $this->assertNotEquals(1,$delete);

   }

    /**
     * @test
     */
    public function filterComplexPatients()
    {
        foreach (range(0,4) as $i)
        {
            $patient = $this->create_patient();
        }
        $patients = DB::table('patients')->get();
        $patientModel = new Patient();
        $complexPatients = $patientModel->getComplexPatients();
        $this->assertLessThanOrEqual($patients->count(),sizeof($complexPatients));
        foreach ($complexPatients as $complexPatient)
        {
            $this->assertEquals('yes',$complexPatient->is_complex);
        }

    }

    /**
     * @test
     */
    public function filterUnder12Patients()
    {
        foreach (range(0,4) as $i)
        {
            $patient = $this->create_patient();
        }
        $patients = DB::table('patients')->get();
        $patientModel = new Patient();
        $under12Patients = $patientModel->getPatientsUnder12();
        $this->assertLessThanOrEqual($patients->count(),sizeof($under12Patients));
        foreach ($under12Patients as $under12Patient)
        {
            $this->assertLessThanOrEqual(12,$patientModel->getAge($under12Patient->date_of_birth));
        }

    }

    /**
     * @test
     */
    public function filterOver12Patients()
    {
        foreach (range(0,4) as $i)
        {
            $patient = $this->create_patient();
        }
        $patients = DB::table('patients')->get();
        $patientModel = new Patient();
        $over12Patients = $patientModel->getPatientsOver12();
        $this->assertLessThanOrEqual($patients->count(),sizeof($over12Patients));
        foreach ($over12Patients as $over12Patient)
        {
            $this->assertGreaterThanOrEqual(12,$patientModel->getAge($over12Patient->date_of_birth));
        }

    }

    /**
     * @test
     */
    public function chronologically_ordered_test_dates()
    {
        foreach (range(0,4) as $i)
        {
            $patient = $this->create_patient();
        }
        $patientModel = new Patient();
        $orderedTests =  $patientModel->getOrderedTestDates();
        $orderedTests2 = Patient::orderBy('test_date')->get();
        foreach (range(0,$orderedTests->count()-1) as $i) {
            $this->assertEquals($orderedTests[$i]->test_date, $orderedTests2[$i]->test_date);
        }

    }

    /**
     * @test
     */
    public function overdue()
    {
        foreach (range(0,4) as $i)
        {
            $patient = $this->create_patient();
        }
        $patientModel = new Patient();
        $overdueTests = $patientModel->getOverdue();
        $overdueTests2 = DB::table('patients')->select('*')->where('test_date','<',date_create('today'))->orderBy('test_date','desc')->get();
        foreach (range(0,sizeof($overdueTests)-1) as $i) {
            $this->assertEquals($overdueTests[$i]->patient_id, $overdueTests2[$i]->patient_id);
        }

    }


}
