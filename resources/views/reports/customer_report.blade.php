@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>
    <div class="card-body">      
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="ussd_customers">
              <thead>                              
                <th>Date created</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Disability status</th>
                <th>Location</th>
                <th>Occupation</th>                
                <th>No. rides btn<br>selected period</th>                
              </thead>
              <tbody>
                @foreach($customers as $customer)                  
                  <tr>                   
                    <td>{{date("d-m-Y",strtotime($customer->sign_up_date))}}</td> 
                    <td>{{$customer->name}}</td>
                    <td>{{str_replace("@gmail.com","",$customer->email)}}</td>
                    <td>{{$customer->sex}}</td>
                    <td>{{$customer->year_of_birth}}</td>
                    <td>{{$customer->disability_status}}</td>
                    <td>{{$customer->location}}</td>
                    <td>{{$customer->occupation}}</td>
                    <td>
                      {{ App\Customer::countCustomerRides($customer->id,$from,$to)  }}
                    </td>
                  </tr>             
                @endforeach
              </tbody>
            </table>             
          </div>
        </div>
      </div>        
@endsection