@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>
    <div class="card-body"> 
 
          
        <div class="row text-center">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="card-box widget-box-one">
                  <div class="wigdet-one-content">

                    <figure class="highcharts-figure">
                        <div id="container"></div>                 
                    </figure>
                       
                       
                  </div>
              </div>
          </div>
        </div>



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
                      </tr>                    
                   @endforeach
                </tbody>
            </table>
           </div>
        </div>
      </div>        
@endsection

@push('scripts')

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
              pointFormat: '<tr><td style="padding:0"><b>{point.y:.1f} Ush</b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              line: {
                  pointPadding: 0.2,
                  borderWidth: 0
              }
          },
          colors:['#8B0000','#FF0000','#B22222','#DC143C','#F08080','#FF4500'],
          series: {!! $records !!}
      });

  </script>

  @endpush