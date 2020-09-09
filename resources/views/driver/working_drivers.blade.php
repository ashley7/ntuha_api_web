@extends('layouts.master')
@section('content')      
  
    <div class="card-box"> 
        <div class="card-body"> 
            <h4>Active Ntuha Rides</h4>
            <table class="table" id="working_drivers">
                <thead>
                   <th>Name</th> <th>Phone Number</th> <th>Driver ID</th> <th>Service</th>
                </thead>

                <tbody>

                    @foreach ($working as $key => $value)  
                       @foreach ($working[$key] as $driver_key => $driver_value)
                         <tr>                             
                             <td>{{$driver_value['name']}}</td>
                             <td>{{$driver_value['phone']}}</td>
                             <td>{{$driver_value['driver_id']}}</td>
                             <td>{{$driver_value['service']}}</td>                            
                         </tr>
                       @endforeach
                    @endforeach                                  
                </tbody>
            </table>
        </div>
    </div>
@endsection
