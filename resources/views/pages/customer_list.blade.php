@extends('layouts.master')

@section('content')
 
<div class="card-box">
    <h4>All our customers</h4>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="working_drivers">
                <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Image</th>                              
                </thead>

                <tbody>
                   @foreach($customers as $customer)
                      <tr>
                          <td><a href="/read_single_customer/{{$customer['customeId']}}">{{$customer['customeId']}}</a> </td>
                          <td>{{$customer['name']}}</td>
                          <td>{{$customer['phone']}}</td>
                          <td>
                            <img src="{{$customer['profileImageUrl']}}" width="40px">
                          </td>
                                                        
                      </tr>                    
                   @endforeach
                </tbody>
            </table>
        </div>                
    </div>
  </div>

       
@endsection

