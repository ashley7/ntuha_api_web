@extends('layouts.master')

@section('content')
<div class="card-box"> 
<h4>All our Drivers</h4>

<div class="card-body">
  <a href="/driver/create" class="btn btn-success">Add new Driver</a>
  <br><br>

    <div class="table-responsive">
        <table class="table table-hover table-striped" id="working_drivers">
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Motor</th>
                <th>Service</th>
                <th>Image</th>                              
            </thead>

            <tbody>
               @foreach($drivers as $driver)
                  <tr>
                      <td><a href="/read_single_driver/{{$driver['driverId']}}">{{$driver['driver_id']}}</a> </td>
                      <td>{{$driver['name']}}</td>
                      <td>{{$driver['phone']}}</td>
                      <td>{{$driver['car']}}</td>
                      <td>{{$driver['service']}}</td>
                      <td>
                        <img src="{{$driver['profileImageUrl']}}" width="40px">
                      </td>
                                                    
                  </tr>                    
               @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>                
@endsection