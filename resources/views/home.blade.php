@extends('layouts.master')
@section('content')
    <div class="row text-center">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Drivers</p>
                    <h2 class="text-danger"><span data-plugin="counterup">{{$drivers}}</span></h2>
                     
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Customers</p>
                    <h2 class="text-dark"><span data-plugin="counterup"> {{$customers}} </span> </h2>
                
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Available drivers</p>
                    <h2 class="text-success"><span data-plugin="counterup">{{$available_drivers}}</span></h2>
               
                </div>
            </div>
        </div><!-- end col -->
    </div>



    <div class="row text-center">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Working driver</p>
                    <h2 class="text-danger"><span data-plugin="counterup">  {{$working_drivers}} </span></h2>
                     
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Rides</p>
                    <h2 class="text-dark"><span data-plugin="counterup">{{$rides}}</span> </h2>
                
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow"></p>
                    <h2 class="text-success"><span data-plugin="counterup"> </span></h2>
               
                </div>
            </div>
        </div><!-- end col -->
    </div>
  
    <div class="card-box"> 
        <div class="card-body"> 
            <h4>Active rides</h4>
            <table class="table" id="working_drivers">
                <thead>
                  <th>Photo</th>  <th>Name</th> <th>Phone Number</th> <th>Driver ID</th> <th>Service</th>
                </thead>

                <tbody>

                    @foreach ($working as $key => $value)  
                       @foreach ($working[$key] as $driver_key => $driver_value)
                         <tr>
                             <td><img src="{{$driver_value['profileImageUrl']}}" width="50px"></td>
                             <td>{{$driver_value['name']}}</td>
                             <td>{{$driver_value['phone']}}</td>
                             <td>{{$driver_value['driver_id']}}</td>
                             <td>{{$driver_value['service']}}</td>                            
                         </tr>
                       @endforeach
                    @endforeach                                  
                </tbody>
            </table>
        </div>
    </div>
@endsection
