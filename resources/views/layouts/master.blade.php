<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured transport system.">
        <meta name="author" content="Thembo Charles Lwanga ()">
        <meta name="author_email" content="ashley7520charles@gmail.com">

         <link rel="icon" href="{{asset('documents/favicon.PNG')}}">

         <title>{{ config('app.name', '') }}</title>

        <link href="{{asset('back_end/assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" />
        <link href="{{asset('back_end/assets/plugins/custombox/css/custombox.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}">
        <link href="{{asset('back_end/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <style type="text/css">
            #topnav .topbar-main {
                background-color: #990E2C;
            }
          
        </style>

        
 

        @yield('styles')

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- Modernizr js -->
        <script src="{{asset('back_end/assets/js/modernizr.min.js')}}"></script>

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
                                    <!-- <img src="back_end/assets/images/users/avatar-1.jpg" alt="{{Auth::user()->name}}" class="img-circle"> -->
                                    <span style="color: #FFF;">{{Auth::user()->name}}</span>
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

                         
                             

                            <li class="has-submenu">
                                <a href="/available_drivers"><i class="zmdi zmdi-whatsapp"></i>  Available drivers</a>
                            </li>

                            <li class="has-submenu">
                                <a href="/get_customers"><i class="zmdi zmdi-account-calendar"></i>  Customers</a>
                            </li>

                            <li class="has-submenu">
                                <a href="/get_drivers"><i class="zmdi zmdi-account-calendar"></i>  Drivers</a>
                            </li>

                            <li class="has-submenu">
                                <a href="/rides"><i class="zmdi zmdi-account-calendar"></i>  Rides</a>
                            </li>                        

                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-collection-bookmark"></i>Settings</a>
                                <ul class="submenu">
                                    <li><a href="/driver">Drivers</a></li>
                                    <li><a href="/price/create">Prices</a></li>
                                </ul>
                            </li>                        
                        </ul>
                    </div>  
                </div>  
            </div>  
        </header>   


      
 
        <div class="wrapper">
            <div class="container">
                @yield('content')    
                <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                              © <?php echo date("Y") ?> Ntuha. All rights reserved
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
        <script src="{{asset('back_end/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('back_end/assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('back_end/assets/plugins/switchery/switchery.min.js')}}"></script>     
        <script src="{{asset('back_end/assets/js/jquery.app.js')}}"></script>    

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
                $('#working_drivers').DataTable( {
                    dom: 'Bfrtip',
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