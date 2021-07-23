@extends('layouts.master')

@section('content')
<?php $counter = 0; ?>
 <div class="card-box">
    <h4>{{$title}}</h4>
    <div class="card-body">

        <div class="row text-center">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="widget-box-one">
              <div class="wigdet-one-content">

                <figure class="highcharts-figure">
                  <h3>No. of active customers in selected period</h3>

                    <div id="container"></div>                 
                </figure>
                   
                   
              </div>
            </div>
          </div>
        </div>


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
                <th>Status</th>                
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
                      <?php
                        $num_rides = App\Customer::countCustomerRides($customer->id,$from,$to); 

                        if($num_rides > 0) {

                          echo "Active";

                          $counter = $counter + 1;

                        }else{

                          echo "Not active";

                        }


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

@push('scripts')
   <script>
     $.(document).ready(function(){

         $("#container").text({{ $counter }})

     })
   </script>

@endpush