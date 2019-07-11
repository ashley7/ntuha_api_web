@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>All Drivers</h4>

    <div class="card-body">

      <a style="float: right;" href="/driver/create" class="btn btn-success">Add new Driver</a>
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
                        <td>{{$topup->customer_name}}</td>
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