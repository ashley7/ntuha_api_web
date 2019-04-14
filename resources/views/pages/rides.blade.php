@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>Rides</h4>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="working_drivers">
                <thead>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Driver</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Distance</th>
                    <th>Total Price</th>
                    <th>Rate</th>
                    <th>Cash</th> 
                    <th>Account</th>
                    <th>Driver amount</th>
                    <th>Ntuha amount</th>
                    <th>Payment type</th>
                    <th>Status</th>
                </thead>

                <tbody>
                   @foreach($ride as $key => $ride_value)
                      <tr>
                          <td>{{$ride_value['date']}}</td>
                          <td>{{$ride_value['customer_name']}}</td>
                          <td>{{$ride_value['driver_name']}}</td>
                          <td>{{$ride_value['from']}}</td>
                          <td>{{$ride_value['to']}}</td>
                          <td>{{$ride_value['distance']}}</td>
                          <td>{{$ride_value['amount_paid']}}</td>                          
                          <td>{{$ride_value['rate']}}</td>
                          <td>{{$ride_value['cash_amount']}}</td>
                          <td>{{$ride_value['account_amount']}}</td>
                          <td>{{$ride_value['driver_amount']}}</td>
                          <td>{{$ride_value['ntuha_amount']}}</td>
                          <td>{{$ride_value['payment_type']}} ({{$ride_value['ride_type']}})</td>
                          <td>
                            @if($ride_value['status'] == 0)
                              <span class="text-danger">Not Paid</span>

                              @elseif($ride_value['status'] == 1)
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