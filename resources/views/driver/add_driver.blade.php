@extends('layouts.master')

@section('content')
             <div class="card-box">
                <h4>Add Driver</h4>

                 @if ($errors->any())
                     @foreach ($errors->all() as $error)
                         <div class="text-danger">{{$error}}</div>
                     @endforeach
                 @endif

                <div class="card-body">
                  <form method="POST" action="{{route('driver.store')}}" enctype="multipart/form-data">
                    @csrf

                      <div class="row">
                        <div class="col-md-6">
                          <label>Name</label>
                          <input type="text" name="name" class="form-control">

                          <!-- <label>Email</label>
                          <input type="email" name="email" class="form-control"> -->

                          <label>Phone number</label>
                          <input type="text" name="phone_number" placeholder="256772123456" class="form-control">

                          <label>Driver number</label>
                          <input type="text" name="driver_id" class="form-control">

                          <label>Identification number</label>
                          <input type="text" name="identification_number" class="form-control">

                          <br>
                           <button id="save_price" class="btn btn-primary">Save</button>

                        </div>
                      <div class="col-md-6">
                          <label>Identification type</label>
                          <select class="form-control" name="identification_type">
                            <option value="National Id">National Id</option>
                            <option value="Driving permit">Driving permit</option>
                          </select>

                          <label>Motor type</label>
                          <input type="text" name="motor_type" class="form-control">

                          <label>Number plate</label>
                          <input type="text" name="number_plate" class="form-control">
                        
                        <label>Service</label>
                        <select class="form-control" name="service">
                          <option value="Ntuha Boda">Ntuha Boda</option>
                          <option value="Ntuha Taxi">Ntuha Taxi</option>
                          <option value="Ntuha Truck">Ntuha Truck</option>
                        </select>

                        <label>Driver photo</label><br>
                        <input type="file" name="input_img" accept="image/*">
                        <br>
                       

                      </div>
                    </div>
                </form>
              </div>
            </div>
            
            
@endsection
 