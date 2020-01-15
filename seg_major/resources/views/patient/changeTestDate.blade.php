@extends('layouts.app.app1')
@section('title')
    <h3 class="media-heading">Edit Test Date</h3>
@endsection

@section('supercontent')
    @csrf
    <div class="container mt-2 mb-4 ">
    <div class="row">
        <div class="medium-12 large-12 columns ml-auto mr-auto p-3" id="pushDownTest">
            <form action="{{ route('changeTestDate',[ 'patient_id' => $patient_id,'page'=>1] ) }}" method="post">
                @csrf

                
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
                
                <div class="medium-12  columns">
                    <button id="submitButton" type="submit" class="btn"  >Save</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
