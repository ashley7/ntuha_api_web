@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Rides</div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="working_drivers">
                            <thead>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Driver</th>
                                <th>Distance</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Rate</th>
                            </thead>

                            <tbody>
                               @foreach($ride as $key => $ride_value)
                                  <tr>
                                      <td>{{$ride_value['date']}}</td>
                                      <td>{{$ride_value['customer_name']}}</td>
                                      <td>{{$ride_value['driver_name']}}</td>
                                      <td>{{$ride_value['distance']}}</td>
                                      <td>{{$ride_value['from']}}</td>
                                      <td>{{$ride_value['to']}}</td>
                                      <td>{{$ride_value['rate']}}</td>
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