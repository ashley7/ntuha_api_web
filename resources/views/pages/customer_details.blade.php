@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                

                <div class="card-body">

                  <div class="row">
                    @foreach($customer as $customer_value)
                    <div class="col-md-4">
                        <img src="{{$customer_value['profileImageUrl']}}" width="50%">                      
                    </div>
                    <div class="col-md-8">
                      <p>Name: {{$customer_value['name']}}</p>
                      <p>Phone number: {{$customer_value['phone']}}</p>                       
                    </div>
                    @endforeach
                  </div>

                  <br><br>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="working_drivers">
                            <thead>
                                <th>Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Driver</th>
                                <th>Distance</th>                              
                                <th>Rate</th>
                                <th>Price</th>                              
                            </thead>

                            <tbody>
                              @foreach($customer_history as $key => $history)
                                <tr>
                                  <td>{{date("Y-M-d",$history['timestamp'])}}</td>
                                  <td>                                 
                                      @foreach($history['location'] as $location_key => $location)
                                        @if($location_key == "from")
                                          {{ $location['lat'] }} , {{$location['lng'] }}
                                        @endif
                                      @endforeach                                  
                                  </td>
                                  <td>{{$history['destination']}}</td>
                                  <td>
                                    @foreach(App\Http\Controllers\NtuhaDashboardController::single_driver($history['driver']) as $driver)
                                      <a href="/read_single_driver/{{$history['driver']}}"> {{$driver['name']}} ({{$driver['phone']}}) </a>
                                    @endforeach                                   
                                  </td>
                                  <td>{{round($history['distance'],3,PHP_ROUND_HALF_UP)}} KM</td>
                                  <td>{{$history['rating']}}</td>
                                  <td>{{1000 * round($history['distance'],3,PHP_ROUND_HALF_UP)}}</td>
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