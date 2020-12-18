@extends('layouts.master')
@section('content')

<h4 style="text-transform: capitalize;">{{$title}}</h4>

<div class="row text-center">
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="card-box widget-box-one">
          <div class="wigdet-one-content">
              <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Rider amount</p>
              <h2 class="text-danger"><span data-plugin="counterup" id="rider_amount"></span></h2>
               
          </div>
      </div>
  </div>

  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="card-box widget-box-one">
          <div class="wigdet-one-content">
              <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Ntuha ride</p>
              <h2 class="text-danger"><span data-plugin="counterup" id="ntuha_amount"></span></h2>
               
          </div>
      </div>
  </div>

  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="card-box widget-box-one">
          <div class="wigdet-one-content">
              <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Total Amount</p>
              <h2 class="text-danger"><span data-plugin="counterup" id="total_amount"></span></h2>
               
          </div>
      </div>
  </div>

</div>

<?php 
  $rider_amount = $ntuha_ride = $total_amount = 0;
?>
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

 <div class="card-box">    
    <div class="card-body">
      <h3>Ride Details</h3>
      <div class="table-responsive">
        <table class="table table-hover table-striped" id="working_drivers">
          <thead>         
            <th>Date</th>
            <th>Driver</th>
            <th>Customer</th>                                              
            <th>From</th>                                              
            <th>To</th>
            <th>Amount</th>                                            
            <th>Driver amount</th>                                            
            <th>Ntuha ride amount</th>                                            
          </thead>
          <tbody>
            @foreach($driver_rides as $rides)
              <tr>
                 <td>{{$rides->date}}
                    @if($rides->id > 28840)
                     {{date("H:i:s",strtotime($rides->created_at))}}                     
                     @else
                     {{date("H:i:s",strtotime($rides->driver->created_at))}}
                    @endif
                  </td>
                 <td>{{$rides->driver->name}}<br>{{$rides->driver->phone_number}}<br>{{$rides->driver->service}}<br>{{$rides->driver->driver_id}}</td>
                 <td>
                  <?php
                    $rider_amount = $rider_amount + ($rides->amount - $rides->ntuha_amount);

                    $ntuha_ride = $ntuha_ride + $rides->ntuha_amount;

                    $total_amount = $total_amount + $rides->amount;

                    try {
                      ?>
                      {{$rides->customer->name}}<br>{{str_replace("@gmail.com","",$rides->customer->email)}}
                      <?php
                       
                     } catch (\Exception $e) {
                       
                     } 
                   ?>
                  
                </td>
                 <td>{{$rides->from}}</td>
                 <td>{{$rides->to}}</td>
                 <td>{{$rides->amount}}</td>
                 <td>{{$rides->amount - $rides->ntuha_amount}}</td>
                 <td>{{$rides->ntuha_amount}}</td>
                     
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
  $("#rider_amount").html("Ush "+{!! $rider_amount !!}) 
  $("#ntuha_amount").html("Ush "+{!! $ntuha_ride !!}) 
  $("#total_amount").html("Ush "+{!! $total_amount !!})
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
        text: 'Daily Rider Revenue'
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
            text: 'Daily Ride Amount (Ush)'
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
    series: {!! $records !!}
});

  </script>
 
@endpush

