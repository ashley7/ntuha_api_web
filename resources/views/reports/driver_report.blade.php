@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>

    <div class="card-body"> 
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="working_drivers">
                <thead>
                    <th>Created at</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Motor</th>
                    <th>Service</th>
                    <th>ID number</th>
                    <th>Status</th>
                    <th>Secret key</th>                    
                    <th>Image</th>
                    <th>Action</th>                           
                </thead>

                <tbody>
                   @foreach($read_local_drivers as $driver)
                      <tr>
                          <td>{{$driver['created_at']}}</td>
                          <td>{{$driver['driver_id']}}</td>
                          <td>{{$driver['name']}}</td>
                          <td>{{$driver['phone_number']}}</td>
                          <td>{{$driver['motor_type']}} ({{$driver['number_plate']}})</td>
                          <td>{{$driver['service']}}</td>

                          <td>{{$driver['identification_number']}} ({{$driver['identification_type']}})</td>

                          <td>

                            <a href="{{route('driver.edit',$driver->id)}}">

                            @if($driver['status'] == 0)

                              <span class="text-danger">No active</span>

                              @else

                              <span class="text-success">Active</span>

                          @endif
                        </a>
                            

                          </td>
                          <td>{{$driver['access_key']}}</td>


                          <td>
                            <img src="{{asset('/images')}}/{{$driver['input_img']}}" width="40px">
                          </td>

                          <td>
                            <form method="POST" action="{{route('driver.destroy',$driver->id)}}">

                              {{csrf_field()}}

                              {{method_field("DELETE")}}
                              <a href="{{route('driver.show',$driver->id)}}">Edit</a>

                              <!-- <button class="btn btn-danger" type="submit">Remove</button> -->
                              

                            </form>
                          </td>
                                                        
                      </tr>                    
                   @endforeach
                </tbody>
            </table>
            {{$read_local_drivers->links()}}
          </div>
        </div>
      </div>        
@endsection