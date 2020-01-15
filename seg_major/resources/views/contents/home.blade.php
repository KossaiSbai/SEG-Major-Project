@extends('layouts.app.app1')


@section('supercontent')

    <div class="testsContainer">

        <form action="{{route('overdue')}}" method = "GET">
            <fieldset>
                <label class="topLabel text-center" style="width:370%" >Overdue Tests</label>
                <input class="images text-center"type="image" src="images/overdue.jpeg" alt="Overdue Tests" style="width:180%">
                <label class="description2 text-center" style="width:400%; font-size: 130%"   >View blood tests not completed on the assigned date</label>
            </fieldset>
        </form>



        <form action="{{route('tests')}}" method = "GET">
            <fieldset>
                <label class="topLabel text-center" style="width:370%">All Tests</label>
                <input class="images" type="image" src="images/tests.jpeg" alt="Future Tests" style="width:180%">
                <label class="description2 text-center" style="width:400%; font-size: 130%"  >Patients' blood tests</label>
            </fieldset>
        </form>

    </div>

    <div class="patientsHospitalsContainer">

        <form action="{{route('patients')}}" method = "GET">
            <fieldset>
                <label class="bottomLabel text-center" style="width:370%">Patients A to Z</label>
                <input class="images"type="image" src="images/patients.jpeg" alt="Patients A to Z" style="width:180%">
                <label class="description text-center" style="width:410%; font-size: 130%" >View details of all the current patients</label>
            </fieldset>
        </form>

        <form action="{{route('hospitals')}}" method = "GET">
            <fieldset>
                <label class="bottomLabel text-center" style="width:370%" >Hospitals A to Z</label>
                <input class="images" type="image" src="images/GPs.jpeg" alt="Local Hospitals A to Z" style="width:180%">
                <label class="description text-center" style="width:410%; font-size: 130%">Contact information about patient's local hospitals</label>
            </fieldset>
        </form>

    </div>


@endsection
@include('flash-messages')

