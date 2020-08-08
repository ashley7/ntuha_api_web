@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>All Ntuha drivers topups</h4>

    <div class="card-body">

       <br><br>

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="working_drivers">
                <thead>
                    <th>Date</th>                  
                    <th>Customer Name</th>
                    <th>Driver Number</th>
                    <th>Amount</th>                
                    <th>Status</th>                
                    <th>Action</th>                           
                </thead>

                <tbody>
                    @foreach($driverTopup as $topup)

                      <tr>
                        <td>{{$topup->created_at}}</td>
                        <td>{{$topup->customer_name}} ({{str_replace("@gmail.com","",$topup->customer_email)}})</td>
                        <td>{{$topup->driver_id}}</td>
                        <td>{{$topup->amount}}</td>
                        <td>{{$topup->status}}</td>
                        <td><a href="{{route('driver_top_up.edit',$topup->id)}}">Change status</a></td>
                      </tr>

                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>        
@endsection