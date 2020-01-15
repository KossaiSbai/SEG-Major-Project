@extends('layouts.app.app1')
@extends('layouts.app.app2')



@section('title')
    <h3 class="media-heading" >Hospitals A to Z</h3>
@endsection

@section('content')

<div id="blood" class="pb-5">
    <table>
        <tr>
            <th>Hospital ID</th>
            <th>Contact</th>
            <th width="25%">Email</th>
            <th>Name</th>
            <th class="settingBtn"><button type="button" class="btn" style="background-color: transparent"><a href="{{route('new_hospital')}}"><img src="images/add.png" class="smallBtn"></a></button></th>
            <th></th>
        </tr>
        <tbody id="bloodtable">
        @foreach($hospitals as $hospital)
        <tr>
            <td>{{$hospital->hospital_id}}</td>
            <td>{{ $hospital->contact }}</td>
            <td>{{$hospital->email}}</td>
            <td>{{$hospital->name}}</td>
            <td class="settingBtn"><button type="button" class="btn" style="background-color: transparent"><a href="{{route('show_hospital',[ 'hospital_id' => $hospital -> hospital_id])}}"><img src="{{asset('images/modify.png')}}" class="smallBtn"></a></button></td>
            <td class="settingBtn"><button class="setting" id="deletePatientButton{{$hospital -> hospital_id}}" @if(\Illuminate\Support\Facades\DB::table("patients")->where("hospital",$hospital->hospital_id)->count() > 0)disabled @endif><img src="{{asset('images/delete.png')}}" class="smallDeleteBtn"></button>

            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal{{$hospital -> hospital_id}}">
               @include('layouts.app.delete_warning')
                            <a role="button" class="btn btn-danger" id="modal-btn-si" style="color: white; text-decoration: none" href="{{route('delete_hospital',[ 'hospital_id' => $hospital -> hospital_id])}}">Delete</a>
                            <a role="button" class="btn btn-secondary text-white" id="modal-btn-no{{$hospital -> hospital_id}}">Cancel</a>
                        </div>
            <script>
                $("#deletePatientButton{{$hospital -> hospital_id}}").on("click", function(){
                    $("#mi-modal{{$hospital -> hospital_id}}").modal('show');
                });

                $("#modal-btn-no{{$hospital -> hospital_id}}").on("click", function(){
                    $("#mi-modal{{$hospital -> hospital_id}}").modal('hide');
                });
            </script>


        </tr>
        @endforeach

            </tbody>
    </table>

</div>


@endsection
@include('flash-messages')