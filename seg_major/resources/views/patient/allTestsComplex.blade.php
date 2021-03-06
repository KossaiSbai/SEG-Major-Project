@extends('layouts.app.app1')
@extends('layouts.app.app2')

@section('title')
    <h3 class="media-heading" >All Tests for Complex Patients</h3>
@endsection

@section('dropdown')
    <div class="filter">
        <button class="dropbtn">Filter By</button>
        <div class="dropdown-content">
            <a href="{{route('tests')}}">All Tests</a>
            <a href="{{route('allTestUnder')}}">Patients under 12</a>
            <a href="{{route('allTestOver')}}">Patients over 12</a>
        </div>
    </div>
@endsection

@section('content')

    @include('layouts.patient.allTestsTableHeader') 
    @include('layouts.patient.allTestsTableBody') 

@endsection
@include('flash-messages')


