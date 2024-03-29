<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured transport system.">
        <meta name="author" content="Thembo Charles Lwanga">
        <meta name="author_email" content="ashley7520charles@gmail.com">

         <link rel="icon" href="{{asset('logo/splash.jpg')}}">

         <title>{{ config('app.name', '') }}</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}">
        <link href="{{asset('back_end/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <style type="text/css">
            #topnav .topbar-main {
                background-color: #8b0000;
            }
          
        </style>
        @yield('styles')
    </head>
    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="/home" class="logo">
                            <i class="zmdi zmdi-case icon-c-logo"></i>
                            <span>{{ config('app.name', '') }}</span>                     
                        </a>
                    </div>
                    <!-- End Logo container-->               


                    <div class="menu-extras">

                        <ul class="nav navbar-nav pull-right">
                            <li class="nav-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>  


                  
                        
                            <li class="nav-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                   @guest
                                   @else
                                    <span style="color: #FFF;">{{Auth::user()->name}}</span>
                                    @endguest
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown " aria-labelledby="Preview">
                                    <!-- item-->                                 
                                      
                                    <a href="{{ route('logout') }}" class="dropdown-item notify-item"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                       <i class="zmdi zmdi-power"> Logout</i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>                             
                                     

                                </div>
                            </li>

                        </ul>

                    </div> <!-- end menu-extras -->
                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                        @guest 

                        @else

                            <li class="has-submenu">
                                <a href="/home"><i class="zmdi zmdi-view-dashboard"></i>  Dashboard</a>
                            </li>                        
                         

                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-bike"></i>Drivers</a>
                                <ul class="submenu">
                                    <li><a href="/available_drivers">Available drivers</a></li>
                                    <!-- <li><a href="/get_drivers">Active Drivers</a></li> -->
                                    <li><a href="/driver">All Drivers</a></li>
                                    <li><a href="/driver/create">Add new Driver</a></li>
                                </ul>
                            </li> 
 

                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-accounts"></i>Customers</a>
                                <ul class="submenu">
                                    <!-- <li><a href="/get_customers">App customers</a></li> -->
                                    <li><a href="/read_customers">Customers</a></li>
                                    <!-- <li><a href="/import_user">Create Customers</a></li> -->
                                </ul>
                            </li> 

                          
                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-balance-wallet"></i>Ntuha Rides</a>
                                <ul class="submenu">                                   
                                   <!-- <li> <a href="/rides">Customer Rides</a></li> -->
                                   <li> <a href="/ntuha_rides">Customer Rides</a></li>

                                   <li> <a href="/ussd_requests">Rides USSD Requests</a></li>

                                   <hr>

                                   <li> <a href="/working_drivers">Active Ntuha Rides</a></li>
                                </ul>
                            </li> 

                             <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-balance-wallet"></i>Ntuha wallet</a>
                                <ul class="submenu">                                   
                                    <li><a href="/transactions">A/C Top-up</a></li>
                                    <li><a href="/driver_top_up">Driver Top-up</a></li>
                                </ul>
                            </li>  

                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-balance-wallet"></i>Reports</a>
                                <ul class="submenu">                                   
                                    <li><a href="/get_revenue_reports">Revenue</a></li>
                                    <li><a href="/load_customer">Customers</a></li>
                                    <li><a href="/get_driver_report">Drivers</a></li>
                                    <li><a href="{{route('ussd_requests.create')}}">USSD rides</a></li>
                                </ul>
                            </li>                        
                          
                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-settings"></i>Settings</a>
                                <ul class="submenu">                                   
                                    <li><a href="/price/create">Prices</a></li>
                                    <li><a href="/user">User</a></li>
                                </ul>
                            </li>                        
                        </ul>

                        @endguest
                    </div>  
                </div>  
            </div>  
        </header>   


      
 
        <div class="wrapper">
            <div class="container">
                @if (session('status'))
                    <div class="text-info" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')    
                <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                              © {{ date("Y") }} {{ config('app.name') }}. All rights reserved
                            </div>
                        </div>
                    </div>
                </footer>         
            </div>  
        </div>  

        <script>
            var resizefunc = [];
        </script>

        <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
        <script src="{{asset('back_end/assets/js/tether.min.js')}}"></script>
        <script src="{{asset('back_end/assets/js/bootstrap.min.js')}}"></script>

        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('js/jszip.min.js') }}"></script>
        <script src="{{ asset('js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('js/buttons.print.min.js') }}"></script>

        <script type="text/javascript">

             $(document).ready(function() {
                $('#working_drivers,#transactions,#ussd_customers').DataTable( {
                    pageLength: 5000,
                    dom: 'Bfrtip',
                    aaSorting: [],
                    ordering: false,
                    buttons: [
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                } );
            } );      
        
        </script>
   
    @stack('scripts')
    </body>
</html>