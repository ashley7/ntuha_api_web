@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>

<?php

  $counter = 0;

  $counterDisplay = 0;

  $dates = [];

  $date_records = [];

  $dateHeaders = [];

  $dateHeaders['name'] = "Daily active riders from ".$from." to ".$to;

?>

    <div class="row text-center">

      <hr>
      <h3>Active riders in selected period:  <span id="count_active"></span></h3>

      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="widget-box-one">
              <div class="wigdet-one-content">               
               
                <figure class="highcharts-figure">
                  <div id="container_active"></div>                 
                </figure>                 
                   
              </div>
          </div>
      </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="widget-box-one">
              <div class="wigdet-one-content">

                <figure class="highcharts-figure">
                    <div id="container"></div>                 
                </figure>
                   
                   
              </div>
          </div>
      </div>
    </div>

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
                    <th>No. rides btn<br>selected period</th>                 
                </thead>

                <tbody>
                   @foreach($read_local_drivers as $driver)

                      <?php $sign_up_date = date("d-m-Y",strtotime($driver['created_at'])); ?>

                      <tr>
                          <td>{{$driver['created_at']}}</td>
                          <td>{{$driver['driver_id']}}</td>
                          <td>{{$driver['name']}}</td>
                          <td>{{$driver['phone_number']}}</td>
                          <td>{{$driver['motor_type']}} ({{$driver['number_plate']}})</td>
                          <td>{{$driver['service']}}</td>

                          <td>
                            {{$driver['identification_number']}} ({{$driver['identification_type']}})
                          </td>

                          <td>
                              <?php 

                                $ridesCount = App\Customer::countDriverRides($driver->id,$from,$to);

                                if($ridesCount > 0){

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
  

         $("#count_active").html({{ $counterDisplay }})

    
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
              text: 'Daily Rider recriutment'
          },
          subtitle: {
              text: 'Source: https://ntuhaug.com'
          },
          xAxis: {
              categories: {!! $days !!},
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
                  enableMouseTracking: false
              }
          },
          colors:['#8B0000','#FF0000','#B22222'],
          series: {!! $records !!}
      });

  </script>

  <script type="text/javascript">

    Highcharts.chart('container_active', {
          chart: {
              type: 'line'
          },
          title: {
              text: 'Daily active Rider'
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
                  text: 'Active Riders'
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
                  enableMouseTracking: false
              }
          },
          colors:['#8B0000','#FF0000','#B22222'],
          series: {!! json_encode($dateHeaders) !!}
      });

  </script>

  @endpush