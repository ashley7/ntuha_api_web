@extends('layouts.master')

@section('content')
 
<div class="card-box">
    <h4>All our customers</h4>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="working_drivers">
                <thead>
                  
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Pin</th>
                    <th>Image</th>
                    <th>Action</th>                              
                </thead>

                <tbody>
                   @foreach($customers as $customer)
                      <tr>
                          
                          <td>{{$customer['name']}}</td>
                          <td>{{$customer['phone']}}</td>
                          <td>{{$customer['pin']}}</td>
                          <td>
                            <img src="{{$customer['profileImageUrl']}}" width="40px">
                          </td>

                          <td><a class="btn btn-success" href="/read_single_customer/{{$customer['customeId']}}">Customer rides</a> </td>
                                                        
                      </tr>                    
                   @endforeach
                </tbody>
            </table>
        </div>                
    </div>
  </div>

       
@endsection

