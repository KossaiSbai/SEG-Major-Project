@extends('layouts.app')

@section('content')
<div class="row">
      <div class="medium-12 large-12 columns">
        <h4>{{$modify == 1 ? 'Modify Hospital' : 'New Hospital'}}</h4>
        <form action="{{($modify == 1 ? route('update_hospital',[ 'hospital_id' => $hospital_id] ) : route('create_hospital'))}}" method="post">
          <div class="medium-4  columns">
            <label>Hospital ID</label>
            <input name="hospital_id" type="text" value="{{(old('hospital_id') ? old('hospital_id') : $hospital_id)}}">
            <small class="error">{{($errors->first('hospital_id'))}}</small>
          </div>
          <div class="medium-4  columns">
            <label>Hospital Name</label>
            <input name="name" type="text" value="{{(old('name') ? old('name') : $name)}}">
            <small class="error">{{($errors->first('name'))}}</small>
          </div>
          <div class="medium-12  columns">
            <label>Email</label>
            <input name="email" type="text" value="{{(old('email') ? old('email') : $email)}}">
            <small class="error">{{($errors->first('email'))}}</small>
          </div>
          <div class="medium-12  columns">
            <label>Contact</label>
            <input name="contact" type="text" value="{{(old('contact') ? old('contact') : $contact)}}">
            <small class="error">{{($errors->first('contact'))}}</small>
          </div>
          <div class="medium-12  columns">
            <label>Preferred Contact</label>
            <select name="preferred_contact">
            <option   value="{{($preferred_contact ? $preferred_contact : 'email')}}" >{{($preferred_contact == 'contact_number' ? 'Contact Number' : 'Email')}}</option>
            <option   value="{{($preferred_contact == 'contact_number' ? 'email' : 'contact_number')}}">{{($preferred_contact =='contact_number' ? 'Email' : 'Contact Number')}}</option>
            </select>
          </div>
          <div class="medium-12  columns">
            <input value="SAVE" class="button success hollow" type="submit">
          </div>
        </form>
      </div>
    </div>
@endsection