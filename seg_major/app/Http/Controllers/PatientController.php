<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestFrequency as TestFrequency;
use App\Patient as Patient;
use App\Hospital as Hospital;
use Carbon\Carbon;
use mysql_xdevapi\Session;

class PatientController extends Controller
{
    /**
     * PatientController constructor.
     * @param Patient $patient
     * @param Hospital $hospital
     * @param TestFrequency $frequency
     */
    public function __construct(Patient $patient,Hospital $hospital, TestFrequency $frequency){
        $this->frequency = $frequency->all();
        $this->patient = $patient;
        $this->hospital = $hospital;
        $this->middleware('auth');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allPatients(){
        $data = [];
        $data['patients'] = $this->patient->all();
        $data['hospitals'] = $this->hospital->getOrderedHospitals();
        $data['frequencies'] = $this->frequency;
        return view('patient/allPatients',$data);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allPatientsUnder12(){
        $data = [];
        $data['patients'] = $this->patient->getPatientsUnder12();
        return view('patient/patientsUnder12',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allPatientsOver12(){
        $data = [];
        $data['patients'] = $this->patient->getPatientsOver12();
        return view('patient/patientsOver12',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filterComplex(){
        $data = [];
        $data['patients'] = $this->patient->getComplexPatients();
        return view('patient/complex_patients',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overdueOver(){
        $data = [];
        $data['patients'] = $this->patient->getOverdueOver12();
        return view('patient/overdueOver12',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overdueUnder(){
        $data = [];
        $data['patients'] = $this->patient->getOverdueUnder12();
        return view('patient/overdueUnder12',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filterOverdueComplex(){
        $data = [];
        $data['patients'] = $this->patient->getOverdueComplex();
        return view('patient/overdueComplex', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allTestUnder12(){
        $data = [];
        $data['patients'] = $this->patient->getAllTestUnder12();
        return view('patient/allTestsUnder', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allTestOver12(){
        $data = [];
        $data['patients'] = $this->patient->getAllTestOver12();
        return view('patient/allTestsOver', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allTestComplex(){
        $data = [];
        $data['patients'] = $this->patient->getAllTestComplex();
        return view('patient/allTestsComplex', $data);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateInput(Request $request){

        $this->validate($request,[
            'forename' => 'required|regex:/^[a-zA-Z]+$/u',
            'surname' => 'required|regex:/^[a-zA-Z]+$/u',
            'patient_id' => 'required|integer|unique:patients',
            'internal_id' => 'required|integer|unique:patients',
            'date_of_birth' => 'required|date|before:today',
            'test_frequency' => 'required',
            'received' => 'required',
            'reviewed' => 'required',
            'preferred_contact' => 'required',
            'hospital' => 'required',
            'contact' => 'required'

        ]);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateInputMod(Request $request){

        $this->validate($request,[
            'forename' => 'required|regex:/^[a-zA-Z]+$/u',
            'surname' => 'required|regex:/^[a-zA-Z]+$/u',
            'patient_id' => 'required|integer|exists:patients',
            'internal_id' => 'required|integer|exists:patients',
            'date_of_birth' => 'required|date|before:today',
            'test_frequency' => 'required',
            'received' => 'required',
            'reviewed' => 'required',
            'preferred_contact' => 'required',
            'email' => 'required|email',
            'hospital' => 'required',

        ]);
    }

    /**
     * @param Request $request
     * @param $patient_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function nextDate(Request $request, $patient_id){
        $pat = Patient::find($patient_id);
        $freq = $pat->test_frequency;

        $dt = new Carbon($pat->test_date);
        if($freq == 'one_week'){
            $pat->test_date = $dt->add(1,'week');
        }
        elseif($freq == 'two_weeks'){
            $pat->test_date = $dt->add(2,'week');
        }
        elseif($freq == 'one_month'){
            $pat->test_date = $dt->add(1,'month');
        }
        elseif($freq == 'three_months'){
            $pat->test_date = $dt->add(3,'month');
        }
        else{
            $pat->test_date = $dt->add(6,'month');
        }
        $pat->reviewed = 'no';
        $pat->received = 'no';

        $pat->save();
       
        return redirect(route('overdue'))->with('status-success', 'Date successfully updated');
    }


    /**
     * @param Request $request
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function newPatient(Request $request,Patient $patient){
        $data = [];
        $data['forename'] = $request->input('forename');
        $data['surname'] = $request->input('surname');
        $data['patient_id'] = $request->input('patient_id');
        $data['internal_id'] = $request->input('internal_id');
        $data['date_of_birth'] = $request->input('date_of_birth');
        $data['sex'] = $request->input('sex');
        $data['test_date'] = $request->input('test_date');
        $data['test_frequency'] = $request->input('test_frequency');
        $data['is_complex'] = $request->input('is_complex');
        $data['received'] =$request->input('received');
        $data['reviewed'] = $request->input('reviewed');
        $data['preferred_contact'] = $request->input('preferred_contact');
        $data['diagnosis'] = $request->input('diagnosis');
        $data['transplant'] = $request->input('transplant');
        $data['contact'] = $request->input('contact');
        $data['email'] = $request->input('email');
        $data['comments'] = $request->input('comments');
        $data['tAC'] = $request->input('tAC');
        $data['hospital'] = $request->input('hospital');

        if($request->isMethod('post')){
            $this->validateInput($request);
            $patient->insert($data);
            return redirect('patients')->with('status-success', 'Patient successfully added');
        }
        $data['modify'] = 0;
        $data['hospitals'] = $this->hospital->getOrderedHospitals();
        $data['frequency'] = $this->frequency;
        return view('patient/form',$data);

    }

    /**
     * @param $patient_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($patient_id){

        $data = [];
        $data['patient_id'] = $patient_id;
        $data['modify'] = 1;
        $data['frequency'] = $this->frequency;
        $data['hospitals'] = $this->hospital->all();
        $patient_data = $this->patient->find($patient_id);
        $data['forename'] = $patient_data->forename;
        $data['surname'] = $patient_data->surname;
        $data['sex'] = $patient_data->sex;
        $data['patient_id'] = $patient_data->patient_id;
        $data['internal_id'] = $patient_data->internal_id;
        $data['date_of_birth'] = $patient_data->date_of_birth;
        $data['test_date'] = $patient_data->test_date;
        $data['test_frequency'] = $patient_data->test_frequency;
        $data['is_complex'] =$patient_data->is_complex;
        $data['received'] =$patient_data->reviewed;
        $data['reviewed'] =$patient_data->reviewed;
        $data['preferred_contact'] =$patient_data->preferred_contact;
        $data['diagnosis'] =$patient_data->diagnosis;
        $data['transplant'] =$patient_data->transplant;
        $data['contact'] =$patient_data->contact;
        $data['email'] = $patient_data->email;
        $data['comments'] = $patient_data->comments;
        $data['tAC'] = $patient_data->tAC;
        $data['hospital'] =$patient_data->hospital;
        return view('patient/form',$data);
    }

    /**
     * @param $patient_id
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTestDate($patient_id,$page){
        $data = [];
        $data['patient_id'] = $patient_id;
        $data['modify'] = 1;
        $data['frequency'] = $this->frequency;
        $data['hospitals'] = $this->hospital->all();
        $patient_data = $this->patient->find($patient_id);
        $data['forename'] = $patient_data->forename;
        $data['surname'] = $patient_data->surname;
        $data['sex'] = $patient_data->sex;
        $data['patient_id'] = $patient_data->patient_id;
        $data['internal_id'] = $patient_data->internal_id;
        $data['date_of_birth'] = $patient_data->date_of_birth;
        $data['test_date'] = $patient_data->test_date;
        $data['test_frequency'] = $patient_data->test_frequency;
        $data['is_complex'] =$patient_data->is_complex;
        $data['received'] =$patient_data->reviewed;
        $data['reviewed'] =$patient_data->reviewed;
        $data['preferred_contact'] =$patient_data->preferred_contact;
        $data['diagnosis'] =$patient_data->diagnosis;
        $data['transplant'] =$patient_data->transplant;
        $data['contact'] =$patient_data->contact;
        $data['email'] = $patient_data->email;
        $data['comments'] = $patient_data->comments;
        $data['tAC'] = $patient_data->tAC;
        $data['hospital'] =$patient_data->hospital;
        $data['page'] = $page;

        return view('patient/changeTestDate',$data);
    }

    /**
     * @param Request $request
     * @param $patient_id
     * @param Patient $patient
     * @param int $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changeTestDate(Request $request, $patient_id, Patient $patient,int $page){


        if($request->isMethod('post')){
            $this->validate($request,[
                'test_frequency' => 'required',
            ]);
            $patient_data = $this->patient->find($patient_id);
            $patient_data->test_date= $request->input('test_date');
            $patient_data->test_frequency = $request->input('test_frequency');     
            $patient_data->save();
            $route = $page == 1 ? 'tests' : 'overdue';
            return redirect(route($route))->with('status-success','Date successfully changed');

        }

    }

    /**
     * @param Request $request
     * @param $patient_id
     * @param Patient $patient
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function modify(Request $request, $patient_id, Patient $patient)
    {

        if($request->isMethod('post')){
            $this->validateInputMod($request);
            $patient_data = $this->patient->find($patient_id);
            $patient_data->forename = $request->input('forename');
            $patient_data->surname = $request->input('surname');
            $patient_data->patient_id = $request->input('patient_id');
            $patient_data->internal_id = $request->input('internal_id');
            $patient_data->date_of_birth = $request->input('date_of_birth');
            $patient_data->sex = $request->input('sex');
            $patient_data->test_date= $request->input('test_date');
            $patient_data->test_frequency = $request->input('test_frequency');
            $patient_data->is_complex = $request->input('is_complex');
            $patient_data->received = $request->input('reviewed');
            $patient_data->reviewed = $request->input('reviewed');
            $patient_data->preferred_contact = $request->input('preferred_contact');
            $patient_data->diagnosis = $request->input('diagnosis');
            $patient_data->transplant = $request->input('transplant');
            $patient_data->contact = $request->input('contact');
            $patient_data->email = $request->input('email');
            $patient_data->comments = $request->input('comments');
            $patient_data->tAC = $request->input('tAC');
            $patient_data->hospital = $request->input('hospital');
            $patient_data->save();
            
            return redirect(route('patients'))->with('status-success', 'Patient successfully updated');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overdueTests()
    {
        $data = [];
        $data['patients'] = $this->patient->getOverdue();
        return view('patient/overdue',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bloodTests()
    {
        $data = [];
        $data['patients'] = $this->patient->getOrderedTestDates();
        return view('patient/blood_tests_table',$data);
    }

    /**
     * @param $patient_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($patient_id)
    {
        Patient::destroy($patient_id);
        return redirect('patients')->with('status-warning', 'Patient successfully deleted');
    }

    /**
     * @param Request $request
     * @param $patient_id
     * @param Patient $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setReviewed(Request $request, $patient_id, Patient $patient){
        if($request->isMethod('post')){
            $patient_data = $this->patient->find($patient_id);
            $patient_data->reviewed = $request->input('reviewed');
            $patient_data->save();
            return redirect()->back()->with('status-success', 'Patient review state updated');
        }
    }

    /**
     * @param Request $request
     * @param $patient_id
     * @param Patient $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setReceived(Request $request, $patient_id, Patient $patient){
        if($request->isMethod('post')){
            $patient_data = $this->patient->find($patient_id);
            $patient_data->received = $request->input('received');
            $patient_data->save();
            return redirect()->back()->with('status-success', 'Patient receive state updated');
        }
    }

}
