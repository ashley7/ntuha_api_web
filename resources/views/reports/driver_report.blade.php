@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>

    <?php $counter = 0; ?>

    <div class="row text-center">

      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
          <div class="widget-box-one">
              <div class="wigdet-one-content">

                <h3>Active riders in selected period</h3>

               
                  <div id="count_active"></div>                 
                 
                   
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

         $("#count_active").text({{ $counter }})

     })
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

  @endpush