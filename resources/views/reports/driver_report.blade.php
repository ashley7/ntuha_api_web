@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>
    <div class="card-body"> 
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="working_drivers">
                <thead>
                    <th>Created at</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Motor</th>
                    <th>Service</th>
                    <th>ID number</th>                 
                </thead>

                <tbody>
                   @foreach($read_local_drivers as $driver)
                      <tr>
                          <td>{{$driver['created_at']}}</td>
                          <td>{{$driver['driver_id']}}</td>
                          <td>{{$driver['name']}}</td>
                          <td>{{$driver['phone_number']}}</td>
                          <td>{{$driver['motor_type']}} ({{$driver['number_plate']}})</td>
                          <td>{{$driver['service']}}</td>

                          <td>{{$driver['identification_number']}} ({{$driver['identification_type']}})</td>
                      </tr>                    
                   @endforeach
                </tbody>
            </table>
           </div>
        </div>
      </div>        
@endsection