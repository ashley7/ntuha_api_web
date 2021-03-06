@extends('layouts.master')

@section('content')
 
<div class="card-box">
   <h4>Drivers Available</h4>

  <div class="card-body">

    <div class="table-responsive">
        <table class="table table-hover table-striped" id="working_drivers">
            <thead>
            
                <th>Name</th>
                <th>Phone Number</th>
                <th>Motor</th>
                <th>Service</th>
                <th>Image</th>                              
            </thead>

            <tbody>
               @foreach($available_drivers as $driver)
                  <tr>
                      
                      <td>{{$driver['name']}}</td>
                      <td>{{$driver['phone']}}</td>
                      <td>{{$driver['car']}}</td>
                      <td>{{$driver['service']}}</td>
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
                                                    
                  </tr>                    
               @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </div>            
@endsection