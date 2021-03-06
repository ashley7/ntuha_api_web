@extends('layouts.master')

@section('content')


  <div class="card-box"> 
    <div class="card-body">
      <div class="row">
        @foreach($driver as $customer_value)
        <div class="col-md-4">

             <?php 
                try {
                  $driver_data = App\Driver::select('input_img')->where('phone_number',$customer_value['phone'])->get()->last();
              ?>
                  <img src="{{asset('/images')}}/{{$driver_data->input_img}}" width="50%">
                <?php
                
              } catch (\Exception $e) {}

               ?>


        </div>
        <div class="col-md-4">
          <p>Name: {{$customer_value['name']}}</p>
          <p>Phone number: {{$customer_value['phone']}}</p>                     
          <p>Motor: {{$customer_value['car']}}</p>                     
          <p>Number Plate: {{$customer_value['car_plate']}}</p>                     
          <p>Service: {{$customer_value['service']}}</p>                    
          <p>Driver number: {{$customer_value['driver_id']}}</p>
          @if($customer_value['category'] == 'Active')                  
          <p>Status: <span class="text-success">{{$customer_value['category']}}</span></p>
          @else 
          <p>Status: <span class="text-danger">{{$customer_value['category']}}</span></p>
          @endif                   
          <p>Subscription type: <span class="text-info">{{$customer_value['subscription_type']}}</span> </p>                    
        </div>

        <div class="col-md-4">

          <a class="btn btn-success" href="/updated_driver_category/{{$driver_key.'*'.$customer_value['category']}}">Change Status</a>

          <a class="btn btn-danger" href="/updated_driver_subscription/{{$driver_key.'*'.$customer_value['subscription_type']}}">Change Subscription type</a>

          <br><br>

          <table class="table table-hover">
            <tr>
              <td>Ntuha amount paid: </td> <td><span id="paid"></span></td>
            </tr>

            <tr>
              <td>Ntuha amount NOT paid: </td> <td><span id="not_paid"></span></td>
            </tr>

            <tr>
              <td>Total driver amount: </td> <td><span id="driver"></span></td>
            </tr>
          </table>

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

                  <?php $sum_paid = $sum_not_paid = $driver_amount = 0; ?>
                  @foreach($driver_history as $key => $history)

                  @php 
                      $driver_amount = $driver_amount + $history['driver_amount'];
                  @endphp
                  
                    <tr>
                      <td>{{date("Y-M-d",$history['timestamp'])}}</td>
                      <td>{{$history['from']}}</td>
                      <td>
                        <?php

                          try {
                              echo $history['destination'];
                           } catch (\Exception $e) {
                             echo "Undefined";
                           } 


                         ?>
                      </td>
                      <td>{{$history['customer_name']}}</td>
                      <td>{{$history['distance']}} KM</td>
                      <td>{{number_format($history['amount_paid'])}}</td>
                      <td>{{$history['rating']}}</td>  

                      <td>{{$history['account_amount']}}</td>
                      <td>{{$history['driver_amount']}}</td>
                      <td>{{$history['ntuha_amount']}}</td>
                      <td>{{$history['payment_type']}} ({{$history['rate_type']}})</td>
                      <td>
                        @if($history['status'] == 0)
                         <a href="/updated_history_status/{{$history['record_key']}}"><span class="text-danger">Not Paid</span></a> 

                          @if($history['rate_type'] != "Free")
                           @php
                             $sum_not_paid = $sum_not_paid + $history['ntuha_amount'];
                           @endphp
                          @endif                     

                          @elseif($history['status'] == 1)
                           <span class="text-success">Paid</span>
                            @php
                              $sum_paid = $sum_paid + $history['ntuha_amount'];
                            @endphp
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

@push('scripts')

  <script>

    $( document ).ready(function() {

      $("#paid").text( {{$sum_paid}} );
      $("#not_paid").text( {{$sum_not_paid}} );
      $("#driver").text( {{$driver_amount}} );      

    });
   
  </script>




@endpush