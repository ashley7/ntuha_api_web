@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-striped" id="working_drivers">
          <thead>         
            <th>Date</th>
            <th>Driver</th>
            <th>Customer</th>                                              
            <th>From</th>                                              
            <th>To</th>
            <th>Amount</th>                                            
            <th>Driver amount</th>                                            
            <th>Ntuha ride amount</th>                                            
          </thead>
          <tbody>
            @foreach($read_ntuha_rides as $rides)
              <tr>
                 <td>{{$rides->date}} {{date("H:i:s",strtotime($rides->driver->created_at))}}</td>
                 <td>{{$rides->driver->name}}<br>{{$rides->driver->phone_number}}<br>{{$rides->driver->service}}<br>{{$rides->driver->driver_id}}</td>
                 <td>{{$rides->customer->name}}<br>{{str_replace("@gmail.com","",$rides->customer->email)}}</td>
                 <td>{{$rides->from}}</td>
                 <td>{{$rides->to}}</td>
                 <td>{{$rides->amount}}</td>
                 <td>{{$rides->amount - $rides->ntuha_amount}}</td>
                 <td>{{$rides->ntuha_amount}}</td>
                     
              </tr>                    
            @endforeach
           </tbody>
         </table>

         {{$read_ntuha_rides->links()}}
       </div>
     </div>
   </div>                
@endsection