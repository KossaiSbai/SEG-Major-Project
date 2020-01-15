<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hospital as Hospital;
use App\Patient as Patient;

class HospitalController extends Controller
{

    /**
     * HospitalController constructor.
     * @param Hospital $hospital
     * @param Patient $patient
     */
    public function __construct( Hospital $hospital, Patient $patient){
        $this->hospital = $hospital;
        $this->patient = $patient;
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $data = [];
        $data['hospitals'] = $this->hospital->all();
        return view('hospitals/index',$data);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateInput(Request $request){
        $this->validate(
            $request,[
            'hospital_id' => 'required|integer',
            'name' => 'required',
            'contact' => 'required',
            'preferred_contact' => 'required',
        ]);

    }

    /**
     * @param Request $request
     * @param Hospital $hospital
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function newHospital(Request $request, Hospital $hospital){
        $data = [];

        $data['hospital_id'] = $request->input('hospital_id');
        $data['name'] = $request->input('name');
        $data['contact'] = $request->input('contact');
        $data['email'] = $request->input('email');
        $data['notes'] = $request->input('notes');
        $data['preferred_contact'] = $request->input('preferred_contact');

        if($request->isMethod('post')){
            $this->validateInput($request) ;
            $hospital->insert($data);
            return redirect(route('hospitals'))->with('status-success', 'Hospital successfully added');;
        }
        $data['modify'] = 0;
        return view('hospitals/form',$data);
    }


    /**
     * @param $hospital_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($hospital_id){
        $data = []; $data['hospital_id'] = $hospital_id;
        $data['modify'] = 1;
        $hospital = $this->hospital->find($hospital_id);
        $data['hospital_id'] = $hospital->hospital_id;
        $data['name'] = $hospital->name;
        $data['notes'] = $hospital->notes;
        $data['preferred_contact'] =$hospital->preferred_contact;
        $data['email'] = $hospital->email;
        $data['contact'] = $hospital->contact;

        return view('hospitals/form', $data);
    }

    /**
     * @param Request $request
     * @param $hospital_id
     * @param Hospital $hospital
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function modify(Request $request, $hospital_id, Hospital $hospital){

        if($request->isMethod('post')){
            $this->validateInput($request);


            $hospital_data = $this->hospital->find($hospital_id);

            $hospital_data->hospital_id = $request->input('hospital_id');
            $hospital_data->name = $request->input('name');
            $hospital_data->preferred_contact = $request->input('preferred_contact');
            $hospital_data->email = $request->input('email');
            $hospital_data->notes = $request->input('notes');
            $hospital_data->contact = $request->input('contact');
            $hospital_data->save();

            return redirect(route('hospitals'))->with('status-success', 'Hospital successfully updated');;
        }

    }

    /**
     * @param $hospital_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($hospital_id)
    {
        Hospital::destroy($hospital_id);
        return redirect('hospitals')->with('status-warning', 'Hospital successfully deleted');
    }


}
