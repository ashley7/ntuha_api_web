@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>Update Driver</h4>                

    <div class="card-body">
      <form method="POST" action="{{route('driver.update',$read_driver->id)}}" enctype="multipart/form-data">
        @csrf
        {{method_field('PATCH')}}

          <div class="row">
            <div class="col-md-6">
              <label>Name</label>
              <input type="text" name="name" value="{{$read_driver->name}}" class="form-control">

              <label>Email</label>
              <input type="email" name="mailer" value="{{$read_driver->email}}" class="form-control">

              <label>Phone number</label>
              <input type="text" name="phone_number" value="{{$read_driver->phone_number}}" class="form-control">

              <label>Driver number</label>
              <input type="text" name="driver_id" value="{{$read_driver->driver_id}}" class="form-control">

              <label>Identification number</label>
              <input type="text" name="identification_number" value="{{$read_driver->identification_number}}" class="form-control">

              
            </div>
          <div class="col-md-6">
              <label>Identification type</label>
              <select class="form-control" name="identification_type">
               @if($read_driver->identification_type == "National Id")
                <option value="National Id" selected>National Id</option>
                <option value="Driving permit">Driving permit</option>
                @else
                <option value="National Id">National Id</option>
                <option value="Driving permit" selected>Driving permit</option>
               @endif
              </select>

              <label>Motor type</label>
              <input type="text" name="motor_type" value="{{$read_driver->motor_type}}" class="form-control">

              <label>Number plate</label>
              <input type="text" name="number_plate" value="{{$read_driver->number_plate}}" class="form-control">
            

            <label>Service</label>
            <select class="form-control" name="service">
              @if($read_driver->service == "Ntuha Boda")
              <option selected value="Ntuha Boda">Ntuha Boda</option>
              <option value="Ntuha Taxi">Ntuha Taxi</option>
              <option value="Ntuha Truck">Ntuha Truck</option>

              @elseif($read_driver->service == "Ntuha Taxi")
              <option value="Ntuha Boda">Ntuha Boda</option>
              <option selected value="Ntuha Taxi">Ntuha Taxi</option>
              <option value="Ntuha Truck">Ntuha Truck</option>
              @elseif($read_driver->service == "Ntuha Truck")
              <option value="Ntuha Boda">Ntuha Boda</option>
              <option value="Ntuha Taxi">Ntuha Taxi</option>
              <option selected value="Ntuha Truck">Ntuha Truck</option>
              @else
               <option value="Ntuha Boda">Ntuha Boda</option>
               <option value="Ntuha Taxi">Ntuha Taxi</option>
               <option value="Ntuha Truck">Ntuha Truck</option>
              @endif
            </select>

            <label>Location</label>
            <select class="form-control" name="location">
              @foreach($locations as $loc)
                @if($read_driver->location == $loc)
                    <option selected value="{{$loc}}">{{$loc}}</option>
                  @else
                    <option value="{{$loc}}">{{$loc}}</option>
                @endif
              @endforeach
            </select>
            
          </div>
        </div>

        <hr>
        <button id="save_price" class="btn btn-primary">Save</button>
    </form>
  </div>
</div>      
@endsection
 