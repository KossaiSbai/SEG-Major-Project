@extends('layouts.app.app1')

@section('title')
    <h3 class="media-heading">{{ $modify == 1 ? 'Edit Hospital' : 'New Hospital' }}</h3>
@endsection

@section('supercontent')
    @csrf
    <div class="container mt-2 mb-4">
        <div class="row">
            <div class="medium-12 large-12 columns ml-auto mr-auto p-3">
                <form action="{{ $modify == 1 ? route('update_hospital',[ 'hospital_id' => $hospital_id] ) : route('create_hospital') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label>Hospital ID<font color="red">*</font></label>
                        <input name="hospital_id" type="text" class="form-control mb-3" value="{{(old('hospital_id') ? old('hospital_id') : $hospital_id)}}">
                        <small class="error">{{($errors->first('hospital_id'))}}</small>
                    </div>
                    <div class="mb-3">
                        <label>Hospital Name<font color="red">*</font></label>
                        <input name="name" type="text" class="form-control mb-3" value="{{(old('name') ? old('name') : $name)}}">
                        <small class="error">{{($errors->first('name'))}}</small>
                    </div>
                    <div class="mb-3">
                        <label>Email<font color="red">*</font></label>
                        <input name="email" type="text" class="form-control mb-3" value="{{(old('email') ? old('email') : $email)}}">
                        <small class="error">{{($errors->first('email'))}}</small>
                    </div>
                    <div class="mb-3">
                        <label>Contact</label>
                        <input name="contact" type="text" class="form-control mb-3"  value="{{(old('contact') ? old('contact') : $contact)}}">
                    </div>
                    <div class="mb-3">
                        <label>Preferred Contact</label>
                        <select name="preferred_contact">
                            <option   value="{{($preferred_contact ? $preferred_contact : 'email')}}" >{{($preferred_contact == 'contact_number' ? 'Contact Number' : 'Email')}}</option>
                            <option   value="{{($preferred_contact == 'contact_number' ? 'email' : 'contact_number')}}">{{($preferred_contact =='contact_number' ? 'Email' : 'Contact Number')}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Notes</label> 
                        <input name="notes" type="text" class="form-control mb-3"  value="{{(old('notes') ? old('notes') : $notes)}}">
                    </div>                        
                    <div class="medium-12  columns">
                        <button id="submitButton" type="submit" class="btn" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection