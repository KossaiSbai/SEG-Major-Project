@extends('layouts.app.app1')
@extends('layouts.app.app2')



@section('title')
    <h3 class="media-heading" >Patients under 12</h3>
@endsection

@section('dropdown')
    <div class="filter">
        <button class="dropbtn">Filter By</button>
        <div class="dropdown-content">
            <a href="{{route('patients')}}">All patients</a>
            <a href="{{route('patients>12')}}">Patients over 12</a>
            <a href="{{route('complex_patients')}}">Complex Patients</a>
        </div>
    </div>
@endsection

@section('content')

    @include('layouts.patient.patientsTableHeader')
    @include('layouts.patient.patientsTableBody')

@endsection