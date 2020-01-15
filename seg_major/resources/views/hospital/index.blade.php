@extends('layouts.app')

@section('content')
<div class="row">
      <div class="medium-12 large-12 columns">
        <h4>Hospitals and Local Surgeries</h4>
        <div class="medium-2  columns"><a class="button hollow success" href="<?php echo e(route('new_hospital')); ?>">ADD NEW HOSPITAL</a></div>
         
        <table class="stack">
          <thead>
            <tr>
              <th width="200">Hospital Name</th>
              <th width="200">Hospital ID</th>
              <th width="200">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($hospital as $hospital)              <tr>
                <td><?php echo e($hospital->name); ?></td>
                <td><?php echo e($hospital->hospital_id); ?></td>
                <td>
                  <a class="hollow button" href="{{ route('show_hospital', ['hospital_id' => $hospital->hospital_id]) }}">EDIT</a>
                </td>
              </tr>
              @endforeach
              
                      </tbody>
        </table>
         
      </div>
    </div>
@endsection