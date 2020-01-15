
<tbody id="bloodtable">
@foreach($patients as $patient)
        <tr>
            <td>{{$patient->forename.'  '.$patient->surname}}</td>
            <td>{{$patient->test_date}}</td>
            <td>{{date_diff(date_create($patient->test_date) , date_create('today'))->days }}</td>
            <td>
            <form action="{{route('receive', $patient->patient_id)}}" method="POST">
                @csrf
                <select name="received"  class="mb-3" style="margin-left: 10px">
                    <option value="{{ $patient->received ? $patient->received : 'no' }}">{{ $patient->received == 'yes' ? 'Yes' : 'No' }}</option>
                    <option value="{{ $patient->received == 'yes' ? 'no' : 'yes' }}">{{ $patient->received == 'yes' ? 'No' : 'Yes' }}</option>
                </select>
                <button id="submitButton" type="submit" class="settingBtn" style="border: none"  >&#10003</button>
            </form> 
            </td>
            <td>
            <form action="{{route('review',$patient->patient_id)}}" method="POST">
                @csrf
                <select name="reviewed"  class="mb-3" style="margin-left: 10px">
                    <option value="{{ $patient->reviewed ? $patient->reviewed : 'no' }}">{{ $patient->reviewed == 'yes' ? 'Yes' : 'No' }}</option>
                    <option value="{{ $patient->reviewed == 'yes' ? 'no' : 'yes' }}">{{ $patient->reviewed == 'yes' ? 'No' : 'Yes' }}</option>
                </select>
                <button id="submitButton" type="submit" class="settingBtn" style="border: none"  >&#10003</button>
            </form>
                @if($patient->reviewed == 'no' || $patient->received == 'no')
                    <button id="submitButton" style="border: none"  type="submit" class="settingBtn" disabled><a  href="#" style="color: white">Request Appointment</a></button>
                @else
                    <button id="submitButton" style="border: none"  type="submit" class="settingBtn" ><a style="color: white" href="{{route('schedule',$patient->patient_id)}}">Request Appointment</a></button>
                @endif
            </td>
            <td class="settingBtn"><button type="button" class="btn" style="background-color: transparent"><a href="{{ route('showTestDate', [ 'patient_id' => $patient -> patient_id,'page'=>1])}}"><img src="{{asset('images/modify.png')}}" class="smallEditBtn"></a></button>


            </td>
            <td>
                <button id="submitButton" type="submit" class="settingBtn" style="border: none"  ><a style="color: white" href="{{route('reschedule',$patient->patient_id)}}">Warning of missed appointment</a></button>
            </td>
        </tr>
            @endforeach
</tbody>
    </table>

</div>