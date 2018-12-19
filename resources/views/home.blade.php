@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-4">
            <div class="card"> 
                <div class="card-body"> 
                 Drivers<br>

                 {{$drivers}}           

                
                </div>
            </div>
        </div>



         <div class="col-md-4">
            <div class="card"> 
                <div class="card-body"> 
                    Customers<br>
                  {{$customers}}                
                </div>
            </div>
        </div>


         <div class="col-md-4">
            <div class="card"> 
                <div class="card-body"> 
                 Available drivers   <br>

                 {{$available_drivers}}             

                
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row">

        <div class="col-md-4">
            <div class="card"> 
                <div class="card-body"> 
                 Working driver <br>

                 {{$working_drivers}}              

                
                </div>
            </div>
        </div>

         <div class="col-md-4">
            <div class="card"> 
                <div class="card-body"> 
                 Rides  <br>

                 {{$rides}}         

                
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="card"> 
                <div class="card-body"> 
                    <h4>Working Drivers</h4>
                    <table class="table" id="working_drivers">
                        <thead>
                          <th>Photo</th>  <th>Name</th> <th>Phone Number</th> <th>Car type</th> <th>Service</th> <th>Number plate</th>
                        </thead>

                        <tbody>

                            @foreach ($working as $key => $value)  
                               @foreach ($working[$key] as $driver_key => $driver_value)
                                 <tr>
                                     <td><img src="{{$driver_value['profileImageUrl']}}"></td>
                                 </tr>
                               @endforeach
                            @endforeach                                  
                              

                             
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
