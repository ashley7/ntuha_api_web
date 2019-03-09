@extends('layouts.master')

@section('content')


  <div class="card-box"> 
    <div class="card-body">
      <div class="row">
        @foreach($driver as $customer_value)
        <div class="col-md-4">
            <img src="{{$customer_value['profileImageUrl']}}" width="50%">                      
        </div>
        <div class="col-md-4">
          <p>Name: {{$customer_value['name']}}</p>
          <p>Phone number: {{$customer_value['phone']}}</p>                     
          <p>Motor: {{$customer_value['car']}}</p>                     
          <p>Number Plate: {{$customer_value['car_plate']}}</p>                     
          <p>Service: {{$customer_value['service']}}</p>                    
          <p>Driver number: {{$customer_value['driver_id']}}</p>
          @if($customer_value['category'] == 'Active')                  
          <p>Status: <span class="btn btn-success">{{$customer_value['category']}}</span></p>
          @else 
          <p>Status: <span class="btn btn-danger">{{$customer_value['category']}}</span></p>
          @endif                   
          <p>Subscription type: {{$customer_value['subscription_type']}}</p>                    
        </div>

        <div class="col-md-4">

          <a class="btn btn-success" href="/updated_driver_category/{{$driver_key.'*'.$customer_value['category']}}">Change Status</a>

          <a class="btn btn-danger" href="/updated_driver_subscription/{{$driver_key.'*'.$customer_value['subscription_type']}}">Change Subscription type</a>

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

                    <th>Account amount</th>
                    <th>Driver amount</th>
                    <th>Ntuha amount</th>
                    <th>Payment type</th>
                    <th>Status</th>                                           
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

                      <td>{{$history['account_amount']}}</td>
                      <td>{{$history['driver_amount']}}</td>
                      <td>{{$history['ntuha_amount']}}</td>
                      <td>{{$history['payment_type']}}</td>
                      <td>
                        @if($history['status'] == 0)
                         <a href="/updated_history_status/{{$history['record_key']}}"><span class="text-danger">Not Paid</span></a>                          

                          @elseif($history['status'] == 1)
                           <span class="text-success">Paid</span>
                        @endif   
                      </td>                   
                    </tr>
 
                  @endforeach                                           
                </tbody>
            </table>
          </div>
        </div>
      </div>                 
@endsection