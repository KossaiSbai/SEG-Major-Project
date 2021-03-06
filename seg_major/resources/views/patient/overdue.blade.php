@extends('layouts.app.app1')
@extends('layouts.app.app2')

@section('title')
    <h3 class="media-heading" >Overdue Tests</h3>
@endsection

@section('dropdown')



        <div class="filter">
            <button class="dropbtn">Filter By</button>
            <div class="dropdown-content">
            <a href="{{route('overdueUnder')}}">Patients under 12</a>
            <a href="{{route('overdueOver')}}">Patients over 12</a>
            <a href="{{route('overdueComplex')}}">Complex Patients</a>
            </div>
        </div>


@endsection

@section('content')

   @include('layouts.patient.overdueTableHeader')
   @include('layouts.patient.overdueTableBody')

@endsection
@include('flash-messages')
