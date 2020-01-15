@extends('layouts.app')

@section('content')
<div class="row">
      <div class="medium-12 large-12 columns">
        <h4>Patients</h4>
        <div class="medium-2  columns"><a class="button hollow success" href="{{ route('new_patient') }}">ADD NEW PATIENT</a></div>


        
        <table class="stack">
          <thead>
            <tr>
              <th width="200">Name</th>
              <th width="200">NHS Number</th>
              <th width="200">Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($patients as $patient)
              <tr>
                <td>{{$patient->forename}} {{$patient->surname}}</td>
                <td>{{$patient->patient_id}}</td>
                <td>
                  <a class="hollow button" href="{{ route('show_patient', ['patient_id' => $patient->patient_id]) }}">EDIT</a>
                </td>
              </tr>
            @endforeach
              
                      </tbody>
        </table>

        
      </div>
    </div>
@endsection