@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All our Drivers</div>

                <div class="card-body">

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
                                      <td><a href="/read_single_driver/{{$driver['driverId']}}">{{$driver['driverId']}}</a> </td>
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
        </div>
    </div>
</div>
@endsection