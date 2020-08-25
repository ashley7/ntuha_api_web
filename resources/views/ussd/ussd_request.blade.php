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
                  <th>Status</th>                                              
                  <th>Action</th>                                              
              </thead>

              <tbody>
                 @foreach($ussd_request as $order)

                 <?php
                   $customer = App\Customer::find($order->customer_id); 

                  ?>
                    <tr>
                       <td>{{$order->created_at}}</td>
                       <td>{{$$customer->name}}<br>
                        {{str_replace("@gmail.com","",$customer->email)}}
                       </td>
                       <td>{{$order->service}}</td>
                       <td>{{$order->product}}</td>
                       <td>{{$order->pick_up_location}}</td>
                       <td>{{$order->destination_location}}</td>
                       <td>{{$order->status}}</td>
                       <td></td>
                          
                    </tr>                    
                 @endforeach
               </tbody>
             </table>
           </div>
         </div>
       </div>                
@endsection