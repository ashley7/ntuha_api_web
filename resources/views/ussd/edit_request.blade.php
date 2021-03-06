@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>Update Ride request</h4>
    <?php 
      try {

        ?>

        <p>Customer Name: {{$readNtuhaRideUssd->customer->name}}</p> 
        <p>Customer Phone: {{str_replace("@gmail.com","",$readNtuhaRideUssd->customer->email)}}

        <?php
        
      } catch (\Exception $e) {
        
      }

     ?>
    </p>             
    <div class="card-body">
      <form method="POST" action="{{route('ussd_requests.update',$readNtuhaRideUssd->id)}}">
        @csrf
        {{method_field('PATCH')}}

          <div class="row">
            <div class="col-md-6">

              <label>Service</label>
              <input type="text" name="service" value="{{$readNtuhaRideUssd->service}}" class="form-control">

              <label>Product</label>
              <input type="text" name="product" value="{{$readNtuhaRideUssd->product}}" class="form-control">

              <label>Pick up location</label>
              <input type="text" name="pick_up_location" value="{{$readNtuhaRideUssd->pick_up_location}}" class="form-control">

              <label>Driver Number</label>
              <input type="text" name="driver_number" class="form-control">
              

            </div>

            <div class="col-md-6">

              <label>Destination location</label>
              <input type="text" name="destination_location" value="{{$readNtuhaRideUssd->destination_location}}" class="form-control">


              <label>Status</label>
              <select class="form-control" name="status">
                <option></option>                         
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="completed">Completed</option>
                <option value="declined">Declined</option>                          
              </select>

              <label>Ride amount</label>
              <input type="number" step="500" min="500" name="amount" value="{{$readNtuhaRideUssd->amount}}" class="form-control">             
            </div>          
        </div>
        <br>
        <button id="save_save_changes" type="submit" class="btn btn-primary">Save changes</button>
    </form>
  </div>
</div>
            
            
@endsection
 