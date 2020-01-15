
<tbody id="bloodtable">

@foreach($patients as $patient)
    @if($patient->is_complex == 'yes')
    <tr style="background-color:#ff9999">
@else
    @endif

        <td><button type="button" class="btn showPatientBtn" data-toggle="modal" data-target="#myPatientModal{{$patient->patient_id}}" >{{$patient->forename}}  {{$patient->surname}}</button>
            <div class="modal fade" id="myPatientModal{{$patient->patient_id}}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="media-body">
                                <div class="row" id="modalHeader">
                                    <h3 class="media-heading" id="textColor">Patient Info</h3>
                                </div>
                                <hr class="text-primary" width="135%">
                            </div>

                            <img class="mr-3" src="images/nhs.jpeg" style="width:150px;" alt="nhs">

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div class="container">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>Name:</td>
                                        <td>{{$patient->forename}}  {{$patient->surname}}</td>
                                    </tr>
                                    <tr>
                                        <td>NHS Number:</td>
                                        <td>{{$patient->patient_id}}</td>
                                    </tr>
                                    <tr>
                                        <td>Internal ID:</td>
                                        <td>{{$patient->internal_id}}</td>
                                    </tr>
                                    <tr>
                                        <td>Sex:</td>
                                        <td>{{$patient->sex == 'male' ? 'Male' : 'Female'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Age:</td>
                                        <td>{{ date_diff(date_create('today')  , date_create($patient->date_of_birth))->y }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth:</td>
                                        <td>{{$patient->date_of_birth}}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact:</td>
                                        <td>{{$patient->contact}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Email:</td>
                                        <td>{{$patient->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Preferred Contact:</td>
                                        <td>{{$patient->preferred_contact == 'email' ? 'Email' : 'Contact Number'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Hospital ID:</td>
                                        <td>{{$patient->hospital}}</td>
                                    </tr>
                                    <tr>
                                        <td>Test Date:</td>
                                        <td>{{$patient->test_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Test Frequency:</td>
                                        <td>{{ucfirst(str_replace('_', ' ',$patient->test_frequency ))}}</td>
                                    </tr>
                                    <tr>
                                        <td>Is the Patient Complex:</td>
                                        <td>{{$patient->is_complex == 'no' ? 'No' : 'Yes'}}</td>
                                    </tr>
                                    <tr>
                                        <td>tAC:</td>
                                        <td>{{$patient->tAC}}</td>
                                    </tr>
                                    <tr>
                                        <td>Diagnosis:</td>
                                        <td>{{$patient->diagnosis}}</td>
                                    </tr>
                                    <tr>
                                        <td>Transplant:</td>
                                        <td>{{$patient->transplant}}</td>
                                    </tr>
                                    <tr>
                                        <td>Received:</td>
                                        <td>{{$patient->received}}</td>
                                    </tr>
                                    <tr>
                                        <td>Reviewed:</td>
                                        <td>{{$patient->reviewed == 'no' ? 'No' : 'Yes'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Comments:</td>
                                        <td>{{$patient->comments}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td>{{$patient->internal_id}}</td>
        <td>{{$patient->preferred_contact == 'contact_number' ? $patient->contact : $patient->email}}</td>
    <td class="settingBtn"><button type="button" class="btn" style="background-color: transparent"><a href="{{route('show_patient',[ 'patient_id' => $patient -> patient_id])}}"><img src="{{asset('images/modify.png')}}" class="smallBtn"></a></button></td>
        <td class="settingBtn"><button class="setting" id="deletePatientButton{{$patient->patient_id}}"><img src="{{asset('images/delete.png')}}" class="smallDeleteBtn"></button>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal{{$patient->patient_id}}">
                    @include('layouts.app.delete_warning')
                    <a role="button" class="btn btn-danger" href="{{route('delete_patient',[ 'patient_id' => $patient -> patient_id])}}">Delete</a>
                    <a role="button" class="btn btn-secondary text-white" id="modal-btn-no{{$patient->patient_id}}">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</td>


    <script>
        $("#deletePatientButton{{$patient->patient_id}}").on("click", function(){
            $("#mi-modal{{$patient->patient_id}}").modal('show');
        });

        $("#modal-btn-no{{$patient->patient_id}}").on("click", function(){
            $("#mi-modal{{$patient->patient_id}}").modal('hide');
        });
    </script>

    </tr>
@endforeach

</tbody>
</table>


</div>