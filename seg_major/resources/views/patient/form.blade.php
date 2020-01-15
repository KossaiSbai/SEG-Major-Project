@extends('layouts.app.app1')

@section('title')
    <h3 class="media-heading">{{ $modify == 1 ? 'Edit Patient' : 'New Patient' }}</h3>
@endsection

@section('supercontent')
    @csrf
    <div class="container mt-2 mb-4 ">
    <div class="row">
        <div class="medium-12 large-12 columns ml-auto mr-auto p-3">
            <form action="{{ $modify == 1 ? route('update_patient',[ 'patient_id' => $patient_id] ) : route('create_patient') }}" method="post">
                @csrf

                <div class="mb-3">
                    <label>Forename <font color="red">*</font></label>
                    <input name="forename" class="form-control mb-3" type="text" value="{{ old('forename') ? old('forename') : $forename }}">
                    <small class="error">{{$errors->first('forename')}}</small>
                </div>
                <div class="mb-3">
                    <label>Surname <font color="red">*</font></label>
                    <input name="surname" type="text" class="form-control mb-3" value="{{ old('surname') ? old('surname') : $surname}}">
                    <small class="error">{{$errors->first('surname')}}</small>
                </div>
                <div class="mb-3">
                    <label>NHS Number <font color="red">*</font></label>
                    <input name="patient_id" type="text" class="form-control mb-3"  value="{{ old('patient_id') ? old('patient_id') : $patient_id }}">
                    <small class="error">{{$errors->first('patient_id')}}</small>
                </div>
                <div class="mb-3">
                    <label>Internal ID <font color="red">*</font></label>
                    <input name="internal_id" type="text" class="form-control mb-3"  value="{{ old('internal_id') ? old('internal_id') : $internal_id }}">
                    <small class="error">{{$errors->first('internal_id')}}</small>
                </div>
                <div class="mb-3">
                    <label>Hospital ID</label>
                    @php


                        $choosen = '';
                        $hosp_name = '';
                        if($hospital != null){
                          $choosen = $hospital;

                        foreach($hospitals as $hosp){
                          if($hosp->hospital_id == $choosen){
                            $hosp_name = $hosp->name;
                          }
                        }
                        }
                    @endphp
                    <select name="hospital" class="form-control mb-3">
                        @if($choosen != '')
                            <option value="{{ $hospital }}">{{ $hosp_name }}</option>
                        @endif

                        @foreach($hospitals as $hosp)
                            @if($hosp->hospital_id != $choosen)
                                <option value="{{ $hosp->hospital_id}}">{{ $hosp->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <small class="error">{{$errors->first('hospital')}}</small>

                </div>
                <div class="mb-3">
                    <label class="mr-2 in">Date of Birth <font color="red">*</font></label><small class="information"><font color="green">Please enter the date with the YYYY-MM-DD format.</font></small>
                    <input name="date_of_birth" class="form-control mb-3" type="text" value="{{ old('date_of_birth') ? old('date_of_birth') : $date_of_birth }}" >
                    <small class="error">{{$errors->first('date_of_birth')}}</small>
                </div>
                <div class="mb-3">
                    <label>Sex</label>
                    <select name="sex" class="form-control mb-3">
                        <option   value="{{ $sex ? $sex : 'male' }}" >{{ $sex == 'female' ? 'Female' : 'Male'}}</option>
                        <option   value="{{ $sex == 'female' ? 'male' : 'female' }}">{{ $sex == 'female' ? 'Male' : 'Female' }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Email <font color="red">*</font></label>
                    <input name="email" type="text"  class="form-control mb-3" value="{{ old('email') ? old('email') : $email }}">
                    <small class="error">{{$errors->first('email')}}</small>
                </div>
                <div class="mb-3">
                    <label>Contact <font color="red">*</font></label> </label>
                    <input name="contact" type="text" class="form-control mb-3" value="{{ old('contact') ? old('contact') : $contact }}">
                    <small class="error">{{$errors->first('contact')}}</small>
                </div>
                <div class="mb-3">
                    <label>Preferred Contact</label>
                    <select name="preferred_contact"  class="form-control mb-3" >
                        <option   value="{{ $preferred_contact ? $preferred_contact : 'email' }}" >{{ $preferred_contact == 'contact_number' ? 'Contact Number' : 'Email'}}</option>
                        <option   value="{{ $preferred_contact == 'contact_number' ? 'email' : 'contact_number' }}">{{ $preferred_contact =='contact_number' ? 'Email' : 'Contact Number' }}</option>
                    </select>

                </div>
                
                <div class="mb-3">
                    <label class="mr-2 in"> Test Date</label>
                    <small class="information"><font color="green">Please enter the date with the YYYY-MM-DD format.</font></small>
                    <input name="test_date" class="form-control mb-3" type="text" value="{{ old('test_date') ? old('test_date') : $test_date }}" >
                    <small class="error">{{$errors->first('test_date')}}</small>
                </div>

                <div class="mb-3">
                    <label>Test Frequency</label>
                    @php
                        $choosen = '';
                        $freq = '';
                        if($test_frequency != null){
                          $choosen = $test_frequency;

                        foreach($frequency as $key => $value){
                          if($key == $choosen){
                            $freq = $value;
                          }
                        }
                        }
                    @endphp
                    <select name="test_frequency"  class="form-control mb-3">
                        @if($choosen != '')
                            <option value="{{ $test_frequency }}">{{ $freq }}</option>
                        @endif
                        @foreach( $frequency as $key => $value )
                            @if($key != $choosen)
                                <option value="{{ $key}}" >{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Is the patient complex</label>
                    <select name="is_complex"  class="form-control mb-3">
                        <option value="{{ $is_complex ? $is_complex : 'no' }}">{{ $is_complex == 'yes' ? 'Yes' : 'No' }}</option>
                        <option value="{{ $is_complex == 'yes' ? 'no' : 'yes' }}">{{ $is_complex == 'yes' ? 'No' : 'Yes' }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Received</label>
                    <select name="received"  class="form-control mb-3">
                        <option value="{{ $received ? $received : 'no' }}">{{ $received == 'yes' ? 'Yes' : 'No' }}</option>
                        <option value="{{ $received == 'yes' ? 'no' : 'yes' }}">{{ $received == 'yes' ? 'No' : 'Yes' }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Reviewed</label>
                    <select name="reviewed"  class="form-control mb-3">
                        <option value="{{ $reviewed ? $reviewed : 'no' }}">{{ $reviewed == 'yes' ? 'Yes' : 'No' }}</option>
                        <option value="{{ $reviewed == 'yes' ? 'no' : 'yes' }}">{{ $reviewed == 'yes' ? 'No' : 'Yes' }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Diagnosis</label>
                    <input name="diagnosis" type="text" class="form-control mb-3" value="{{ old('diagnosis') ? old('diagnosis') : $diagnosis }}">
                    <small class="error">{{$errors->first('diagnosis')}}</small>
                </div>
                <div class="mb-3">
                    <label>Transplant</label>
                    <input name="transplant" type="text" class="form-control mb-3" value="{{ old('transplant') ? old('transplant') : $transplant }}">
                    <small class="error">{{$errors->first('transplant')}}</small>
                </div>

                <div class="mb-3">
                    <label>tAC</label>
                    <input name="tAC" type="text"   class="form-control mb-3"value="{{ old('tAC') ? old('tAC') : $tAC }}">
                    <small class="error">{{$errors->first('tAC')}}</small>
                </div>
                <div class="mb-3">
                    <label>Comments</label>
                    <input name="comments" type="text"  class="form-control mb-3" value="{{ old('comments') ? old('comments') : $comments }}">
                    <small class="error">{{$errors->first('comments')}}</small>
                </div>
                <div class="medium-12  columns">
                    <button id="submitButton" type="submit" class="btn" >Save</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection