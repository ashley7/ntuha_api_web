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
            <th>Gender</th>                                              
            <th>Occupation</th>                                              
            <th>Disability status</th>                                              
            <th>From</th>                                              
            <th>To</th>
            <th>Amount</th>                                            
            <th>Driver amount</th>                                            
            <th>Ntuha ride amount</th>                                            
          </thead>
          <tbody>
            @foreach($read_ntuha_rides as $rides)
              <tr>
                 <td>{{$rides->date}}
                    @if($rides->id > 28840)
                     {{date("H:i:s",strtotime($rides->created_at))}}                     
                     @else
                     {{date("H:i:s",strtotime($rides->driver->created_at))}}
                    @endif
                  </td>
                 <td>{{$rides->driver->name}}<br>{{$rides->driver->phone_number}}<br>{{$rides->driver->service}}<br>{{$rides->driver->driver_id}}</td>
                 
                 <td>{{ $rides->customer->sex }}</td>
                 <td>{{ $rides->customer->occupation }}</td>
                 <td>{{ $rides->customer->disability_status }}</td>
                 <td>
                  <?php
                    try {
                      ?>
                      {{$rides->customer->name}}<br>{{str_replace("@gmail.com","",$rides->customer->email)}}
                      <?php
                       
                     } catch (\Exception $e) {
                       
                     } 
                   ?>
                  
                </td>
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