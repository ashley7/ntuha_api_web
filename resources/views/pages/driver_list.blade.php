@extends('layouts.master')

@section('content')
<div class="card-box"> 
<h4>All our Drivers</h4>

<div class="card-body">
  <a href="/driver/create" class="btn btn-success">Add new Driver</a>
  <br><br>

    <div class="table-responsive">
        <table class="table table-hover table-striped" id="working_drivers">
            <thead>
                <th>Number</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Motor</th>
                <th>Service</th>
                <th>Status</th>
                <th>Subscription Type</th>
                <th>Image</th> 
                <th>Action</th>                             
            </thead>

            <tbody>
               @foreach($drivers as $driver)
                  <tr>
                      <td>{{$driver['driver_id']}}</td>
                      <td>{{$driver['name']}}</td>
                      <td>{{$driver['phone']}}</td>
                      <td>{{$driver['car']}}</td>
                      <td>{{$driver['service']}}</td>
                      <td>{{$driver['category']}}</td>
                      <td>{{$driver['subscription_type']}}</td>
                      <td>

                          <?php 
                              try {
                                $driver_data = App\Driver::select('input_img')->where('phone_number',$driver['phone'])->get()->last();
                            ?>
                                <img src="{{asset('/images')}}/{{$driver_data->input_img}}" width="40px">
                              <?php                              
                            } catch (\Exception $e) {}
                          ?>


                      </td>

                      <td>
                      	<a class="btn btn-success" href="/read_single_driver/{{$driver['driverId']}}">Details</a>
                      </td>
                                                    
                  </tr>                    
               @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>                
@endsection