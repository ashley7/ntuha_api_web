@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>List of USSD Service requests</h4>
    <div class="card-body"> 
    <br><br>
      <div class="table-responsive">
          <table class="table table-hover table-striped" id="working_drivers">
              <thead>         
                  <th>Created at</th>
                  <th>Name</th>
                  <th>Service</th>
                  <th>Product</th>                                              
                  <th>From</th>                                              
                  <th>To</th> 
                  <th>Ride Amount</th>                                             
                  <th>Status</th>                                              
                  <th>Action</th>                                              
              </thead>

              <tbody>
                 @foreach($ussd_request as $order) 
                    <tr>
                       <td>{{$order->created_at}}</td>
                       <td>{{$order->customer->name}}<br>
                        {{str_replace("@gmail.com","",$order->customer->email)}}
                       </td>
                       <td>{{$order->service}}</td>
                       <td>{{$order->product}}</td>
                       <td>{{$order->pick_up_location}}</td>
                       <td>{{$order->destination_location}}</td>
                       <td>{{$order->amount}}</td>
                       <td>
                        @if($order->status == "pending")
                          <span class="text-warning">{{$order->status}}</span>
                        @elseif($order->status == "completed")
                          <span class="text-success">{{$order->status}}</span>
                        @elseif($order->status == "declined")
                          <span class="text-danger">{{$order->status}}</span>
                        @elseif($order->status == "accepted")
                          <span class="text-info">{{$order->status}}</span>
                        @endif

                        </td>
                       <td>
                         <a href="{{route('ussd_requests.edit',$order->id)}}">Edit</a>
                       </td>                          
                    </tr>                    
                 @endforeach
               </tbody>
             </table>
           </div>
         </div>
       </div>                
@endsection