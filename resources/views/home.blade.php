@extends('layouts.master')
@section('content')
    <div class="row text-center">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Drivers</p>
                    <h2 class="text-danger"><span data-plugin="counterup">{{$drivers}}</span></h2>
                     
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Customers</p>
                            <h2 class="text-dark"><span data-plugin="counterup"> {{$customers}} </span> </h2>
                        </div>

                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <div class="vl"></div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Famers</p>
                            <h2 class="text-dark"><span data-plugin="counterup"> {{$famers}} </span> </h2>
                        </div>                       

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Commuters</p>
                            <h2 class="text-dark"><span data-plugin="counterup"> {{$commuters}} </span> </h2>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Both</p>
                            <h2 class="text-dark"><span data-plugin="counterup"> {{$both}} </span> </h2>
                        </div>
                        
                    </div>
                    
                
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Available drivers</p>
                    <h2 class="text-success"><span data-plugin="counterup">{{$available_drivers}}</span></h2>
               
                </div>
            </div>
        </div><!-- end col -->
    </div>



    <div class="row text-center">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Working driver</p>
                    <h2 class="text-danger"><span data-plugin="counterup">  {{$working_drivers}} </span></h2>
                     
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">App Rides</p>
                    <h2 class="text-dark"><span data-plugin="counterup"> ... </span> </h2>
                
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">USSD Rides</p>
                    <h2 class="text-success"><span data-plugin="counterup">... </span></h2>               
                </div>
            </div>
        </div><!-- end col -->
    </div> 

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                   <div id="age" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div> 

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                   <div id="female_age" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                   <div id="male_age" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div> 

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                   <div id="gender" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                   <div id="male_customers" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                   <div id="female_customers" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>

         
     </div> 
 
@endsection

@section('styles')

<style>
    .vl {
      border-left: 3px solid #8b0000;
      height: 50px;
    }
</style>

@endsection

@push('scripts')
    <script src="{{asset('js/charts/highcharts.js')}}"></script>
    <script src="{{asset('js/charts/highcharts-3d.js')}}"></script>
    <script src="{{asset('js/charts/exporting.js')}}"></script>
    <script src="{{asset('js/charts/export-data.js')}}"></script>  

    <script>
        renderGraph('age','pie','Farmer age count',{!! json_encode($ageArray) !!})
        renderGraph('male_age','pie','Male farmer age count',{!! json_encode($maleAgeArray) !!})
        renderGraph('female_age','pie','Female farmer age count',{!! json_encode($femaleAgeArray) !!})
        renderGraph('gender','pie','Farmer Gender',{!! json_encode($gender) !!})
        renderGraph('male_customers','pie','Male Occupation',{!! json_encode($maleOccupation) !!})
        renderGraph('female_customers','pie','Female Occupation',{!! json_encode($femaleOccupation) !!})

        function renderGraph(chart_id,chart_type,chart_title,chart_data) {            
      
            Highcharts.chart(chart_id, {
                chart: {
                    type: chart_type,
                    options3d: {
                        enabled: false,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: chart_title
                },
               
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: <b>{point.percentage:.1f}%</b>'
                        }
                    }
                },
                colors:['#8B0000','#FF0000','#B22222','#DC143C','#F08080','#FF4500'],
                series: [{
                    type: 'pie',
                    name: 'Number of Farmer',
                    data:  chart_data
                }]
            });
        }
    </script>
@endpush
