@extends('layouts.master')

@section('content')
<?php 

$counter = 0;
$counterDisplay = 0;

$dates = [];
$date_records = [];
$dateHeaders = [];

$dateHeaders['name'] = "Daily active riders from ".$from." to ".$to;



?>
 <div class="card-box">
    <h4>{{$title}}</h4>
    <div class="card-body">

        <div class="row text-center">
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="widget-box-one">
              <div class="wigdet-one-content">

                  <hr>
               
                  <h3>No. of active customers in selected period</h3>

                  <h1>  <div id="count_active"></div>       </h1>
               
                   
                   
              </div>
            </div>
          </div>

          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <div class="widget-box-one">
                <div class="wigdet-one-content">

                  <figure class="highcharts-figure">
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

                  <?php $sign_up_date = date("d-m-Y",strtotime($customer->sign_up_date)); ?>                 
                  <tr>                   
                    <td>{{ $sign_up_date }}</td> 
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

                          $counterDisplay = $counterDisplay + 1;
                         
                          $dates[] = $sign_up_date;

                          $dates = array_unique($dates);

                          $counter = $counter + 1;

                          $date_records[] = $counter;

                          if (in_array($sign_up_date, $dates)) {

                            $key = array_search($sign_up_date, $dates);
                                                   
                            $date_records[$key] = ($date_records[$key] + 1); 

                            $counter = 0;           
                          
                            
                          }

                        }else{

                          echo "Not active";

                        }


                       ?>
                    </td>
                  </tr>             
                @endforeach
              </tbody>
            </table>

            <?php

            foreach (array_keys($date_records, 1) as $key) {
                unset($date_records[$key]);
            }

              

              $dateHeaders['data'] = $date_records;

             ?>       
          </div>
        </div>
      </div>        
@endsection

@push('scripts')
   <script>  
      $("#count_active").text({{ $counterDisplay }})  
   </script>

 

  <script src="{{asset('js/charts/highcharts.js')}}"></script>
  <script src="{{asset('js/charts/highcharts-3d.js')}}"></script>
  <script src="{{asset('js/charts/exporting.js')}}"></script>
  <script src="{{asset('js/charts/export-data.js')}}"></script>  

  <script type="text/javascript">

    Highcharts.chart('container', {
          chart: {
              type: 'line'
          },
          title: {
              text: 'Active customers'
          },
          subtitle: {
              text: 'Source: https://ntuhaug.com'
          },
          xAxis: {
              categories: {!! json_encode($dates) !!},
              crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Daily Riders'
              }
          },
          tooltip: {
              headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
              pointFormat: '<tr><td style="padding:0"><b>{point.y:.0f} Riders</b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              line: {
                  pointPadding: 0.2,
                  borderWidth: 0,
                  dataLabels: {
                      enabled: true
                  },
                  enableMouseTracking: true
              }
          },
          colors:['#8B0000','#FF0000','#B22222'],
          series: {!!  json_encode([$dateHeaders]) !!}
      });

  </script>

  @endpush