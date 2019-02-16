@extends('layouts.master')

@section('content')
  <div class="card-box"> 
    <div class="card-body">
      <div class="row">
        @foreach($driver as $customer_value)
        <div class="col-md-4">
            <img src="{{$customer_value['profileImageUrl']}}" width="50%">                      
        </div>
        <div class="col-md-8">
          <p>Name: {{$customer_value['name']}}</p>
          <p>Phone number: {{$customer_value['phone']}}</p>                     
          <p>Motor: {{$customer_value['car']}}</p>                     
          <p>Number Plate: {{$customer_value['car_plate']}}</p>                     
          <p>Service: {{$customer_value['service']}}</p>                    
          <p>Driver number: {{$customer_value['driver_id']}}</p>                    
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
                    <th>Customer</th>
                    <th>Distance</th>
                    <th>Price</th>                              
                    <th>Rate</th>                                                 
                </thead>

                <tbody>
                  @foreach($driver_history as $key => $history)
                    <tr>
                      <td>{{date("Y-M-d",$history['timestamp'])}}</td>
                      <td>{{$history['from']}}</td>
                      <td>{{$history['destination']}}</td>
                      <td>{{$history['customer_name']}}</td>
                      <td>{{$history['distance']}} KM</td>
                      <td>{{number_format($history['amount_paid'])}}</td>
                      <td>{{$history['rating']}}</td>                     
                    </tr>
                  @endforeach                                           
                </tbody>
            </table>
          </div>
        </div>
      </div>                 
@endsection