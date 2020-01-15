<tbody id="bloodtable">
@foreach($patients as $patient)
    @if($patient->test_date != null)

        <tr>
            <td>{{$patient->forename.'  '.$patient->surname}}</td>
            <td>{{$patient->test_date}}</td>
            <td>{{date_create('today') <= date_create($patient->test_date) ? date_diff(date_create('today') , date_create($patient->test_date))->days : 'Test is overdue.' }}</td>
            <td>{{$patient->preferred_contact == 'email' ? $patient->email : $patient->contact}}</td>
            <td>{{ ucfirst(str_replace('_', ' ',$patient->test_frequency )) }}</td>
            <td>
                <form action="{{route('receive', $patient->patient_id)}}" method="POST">
                    @csrf
                    <select name="received"  class="mb-3" style="margin-left: 5px">
                        <option value="{{ $patient->received ? $patient->received : 'no' }}">{{ $patient->received == 'yes' ? 'Yes' : 'No' }}</option>
                        <option value="{{ $patient->received == 'yes' ? 'no' : 'yes' }}">{{ $patient->received == 'yes' ? 'No' : 'Yes' }}</option>
                    </select>
                    <button id="submitButton" type="submit" class="settingBtn" style="border: none"  >&#10003</button>
                </form>
            </td>
            <td>
                <form action="{{route('review',$patient->patient_id)}}" method="POST">
                    @csrf
                    <select name="reviewed"  class="mb-3" style="margin-left: 5px">
                        <option value="{{ $patient->reviewed ? $patient->reviewed : 'no' }}">{{ $patient->reviewed == 'yes' ? 'Yes' : 'No' }}</option>
                        <option value="{{ $patient->reviewed == 'yes' ? 'no' : 'yes' }}">{{ $patient->reviewed == 'yes' ? 'No' : 'Yes' }}</option>
                    </select>
                    <button id="submitButton" type="submit" class="settingBtn" style="border: none"  >&#10003</button>
                </form>
                @if($patient->reviewed == 'no')
                    <button id="submitButton" style="border: none"  type="submit" class="settingBtn" ><a  href="#" style="color: white">Request Appointment</a></button>
                @else
                    <button id="submitButton" style="border: none"  type="submit" class="settingBtn" ><a style="color: white" href="{{route('schedule',$patient->patient_id)}}">Request Appointment</a></button>
                @endif
            </td>
            <td class="settingBtn"><button type="button" class="btn" style="background-color: transparent"><a href="{{ route('showTestDate', [ 'patient_id' => $patient -> patient_id, 'page' => 0])}}"><img src="{{asset('images/modify.png')}}" class="smallEditBtn"></a></button>
            <td><button type="submit" class="notificationButton"><a style="color: white" href="{{route('notification',$patient->patient_id)}}"> Send notification</a></button></td>
        </tr>


    @endif
@endforeach

</tbody>
</table>
</div>