@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Inactive Drivers</div>

                <div class="card-body">

                  <a style="float: right;" href="/driver/create" class="btn btn-success">Add new Driver</a>
                  <br><br>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="working_drivers">
                            <thead>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Motor</th>
                                <th>Service</th>
                                <th>ID number</th>
                                <th>Image</th>                              
                            </thead>

                            <tbody>
                               @foreach($read_local_drivers as $driver)
                                  <tr>
                                      <td>{{$driver['driver_id']}}</td>
                                      <td>{{$driver['name']}}</td>
                                      <td>{{$driver['phone_number']}}</td>
                                      <td>{{$driver['motor_type']}} ({{$driver['number_plate']}})</td>
                                      <td>{{$driver['service']}}</td>
                                      <td>{{$driver['identification_number']}} ({{$driver['identification_type']}})</td>
                                      <td>
                                        <img src="{{asset('/images')}}/{{$driver['input_img']}}" width="40px">
                                      </td>
                                                                    
                                  </tr>                    
                               @endforeach
                            </tbody>
                        </table>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection