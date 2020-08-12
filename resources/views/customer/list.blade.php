@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>

    <div class="card-body">

      <a href="/customer" class="btn btn-success">Add new Customer</a>
      <br><br>

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="ussd_customers">
                <thead>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Sex</th>
                    <th>Year of birth</th>
                    <th>Disability status</th>
                    <th>Location</th>
                    <th>Occupation</th>                    
                    <th>Sign up date</th>
                    <th>Description</th>                           
                </thead>

                <tbody>

                  @foreach($customers as $customer)

                    <tr>
                      <td>{{$customer->created_at}}</td>
                      <td>{{$customer->name}}</td>
                      <td>{{str_replace("@gmail","",$customer->email)}}</td>
                      <td>{{$customer->sex}}</td>
                      <td>{{$customer->year_of_birth}}</td>
                      <td>{{$customer->disability_status}}</td>
                      <td>{{$customer->location}}</td>
                      <td>{{$customer->occupation}}</td>
                      <td>{{$customer->description}}</td>
                      <td>{{$customer->agent_name}}</td>
                    </tr>

                  @endforeach
                  
                </tbody>
            </table>

            {{$customers->links()}}
          </div>
        </div>
      </div>        
@endsection