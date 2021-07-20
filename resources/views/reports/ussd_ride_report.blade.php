@extends('layouts.master')

@section('content')
<h4 style="text-transform: capitalize;">{{$title}}</h4>

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
        <div class="table-responsive">
          <table class="table table-hover table-striped" id="working_drivers">
              <thead>         
                  <th>Created at</th>
                  <th>Customer</th>
                  <td>Gender</td>
                  <td>Occupation</td>
                  <td>Disability status</td>
                  <th>Driver</th>
                  <th>Service</th>
                  <th>Product</th>                                              
                  <th>From</th>                                              
                  <th>To</th> 
                  <th>Ride Amount</th>                                             
                  <th>Status</th>                                              
                  <th>Action</th>                                              
              </thead>

              <tbody>
                 @foreach($ussd_request as $order) 
                    <tr>
                       <td>{{$order->created_at}}</td>
                       <td>
                        <?php
                          try {

                            ?>
                            {{$order->customer->name}}<br>
                            {{str_replace("@gmail.com","",$order->customer->email)}}
                            <?php
                             
                           } catch (\Exception $e) {} 

                         ?>
                        
                       </td>

                      <td>
                        <?php 

                          try {
                            echo $order->customer->sex;
                          } catch (\Exception $e) {}

                         ?>
                      </td>

                      <td>
                        <?php 
                        try {
                          echo $order->customer->occupation;
                        } catch (\Exception $e) {}

                         ?>
                      </td>
                      <td><?php 

                        try {
                          echo $order->customer->disability_status;
                        } catch (\Exception $e) {}


                       ?></td>
                      
                      <td>
                        <?php 
                        try {
                          ?>

                          {{$order->driver->name}}<br>
                          {{$order->driver->phone_number}}<br>
                          {{$order->driver->service}}<br>
                          {{$order->driver->driver_id}}

                       
                        <?php 
                        } catch (\Exception $e) {}

                         ?>
                       </td>
                       <td>{{$order->service}}</td>
                       <td>{{$order->product}}</td>
                       <td>{{$order->pick_up_location}}</td>
                       <td>{{$order->destination_location}}</td>
                       <td>{{$order->amount}}</td>
                       <td>
                        @if($order->status == "pending")
                          <span class="text-warning">{{$order->status}}</span>
                        @elseif($order->status == "completed")
                          <span class="text-success">{{$order->status}}</span>
                        @elseif($order->status == "declined")
                          <span class="text-danger">{{$order->status}}</span>
                        @elseif($order->status == "accepted")
                          <span class="text-info">{{$order->status}}</span>
                        @endif

                        </td>
                       <td>
                         <a href="{{route('ussd_requests.edit',$order->id)}}">Edit</a>
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
              text: 'Daily USSD Revenue and Ride count'
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
          colors:['#8B0000','#FF0000','#B22222','#DC143C','#F08080','#FF4500'],
          series: {!! $records !!}
      });

  </script>

  @endpush