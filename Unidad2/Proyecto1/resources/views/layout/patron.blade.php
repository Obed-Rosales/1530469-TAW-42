<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-widyh, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo')</title>

    <!-- Botstrap -->
    <link href="{{asset('css/botstrap.min.css') }}" rel="stylesheet">
    <!-- Font awesome -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-o53vJWv+oUjzBfQzYUhtDYW+Pj2yciDJxpsK10YPAYjqT085Qq/1cq5FLXAZ!7Ay"
    crossorigin="anonymous">
    <!-- NProgress -->
    <link href="{{asset('css/nprogress.css') }}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet" />
    <!-- iCheck -->
    <link href="{{ asset('css/prettify.min.css') }}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->    
    <link href="{{ asset('') }}">

    
    
    
    
    <!-- Falta de agregar mas enlaces -->






</head>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

<body class="nav-md">
    <div class="container body">
        <div class="main-container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ url('/') }}" class="site_title"><span style="font-size: 19px;">Sistema de control de empleados</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <br />

                    <!-- sidebar menu-->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>Menu</h3>
                                <ul class="nav side-menu">
                                    <li><a href="{{url('dashboard')}}">Inicio</a></li>
                                </ul>
                                <ul class="nav side-menu">
                                    <li><a><i class="fas fa-user-shield"></i>&nbsp;&nbsp;&nbsp;&nbsp;Empleados <span style="float: right" class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{url('empleados/create')}}">Agregar empleado</a></li>
                                            <li><a href="{{url('empleados')}}">Agregar empleado</a></li>
                                        </ul>
                                    </li>
                                </ul>
                        </div>
                    </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->

        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top">
                <span class="glyphicon" arian-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top">
                <span class="glyphicon" arian-hidden="true"></span>
            </a>
            <a href="/password" data-toggle="tooltip" data-placement="top">
                <i class="fas fa-key"></i>
            </a>

        </div>
        <!-- /menu footer buttons -->
    </div>
</div>

<!-- MUESTRA EL CONTENIDO DE LA SECCION "contenido" LA CUAL PUEDE SER: LISTADO O ALTA DE EMPLEADOS. -->
    @yield('contenido')

    @yield('scripts')


<!-- pendiente de terminar -->



<!-- jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('js/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('js/nprogress.js') }}"></script>
<!-- Chart.js -->
<script src="{{ asset('js/Chart.min.js') }}"></script>
<!-- jQuery Sparklines -->
<script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
<!-- gauge.js -->
<script src="{{ asset('js/gauge.min.js') }}"></script>
<!-- jQuery custom content scroller -->
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset('js/bootstrap-progressbar.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('js/icheck.min.js') }}"></script>
<!-- Skycons -->
<script src="{{ asset('js/skycons.js') }}"></script>
<!-- Flot -->
<script src="{{ asset('js/jquery.flot.js') }}"></script>
<script src="{{ asset('js/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('js/jquery.flot.time.js') }}"></script>
<script src="{{ asset('js/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('js/jquery.flot.resize.js') }}"></script>
<!-- Flot plugins -->
<script src="{{ asset('js/jquery.flot.orderBars.js') }}"></script>
<script src="{{ asset('js/jquery.flot.spline.min.js') }}"></script>
<script src="{{ asset('js/curvedLines.js') }}"></script>
<!-- DateJS -->
<script src="{{ asset('js/date.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('js/jquery.vmap.js') }}"></script>
<script src="{{ asset('js/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('js/jquery.vmap.sampledata.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<!-- bootstrap-wysiwyg -->
<script src="{{ asset('js/bootstrap-wysiwyg.min.js') }}"></script>
<script src="{{ asset('js/jquery.hotkeys.js') }}"></script>
<script src="{{ asset('js/prettify.js') }}"></script>
<!-- jQuery Tags Input -->
<script src="{{ asset('js/jquery.tagsinput.js') }}"></script>
<!-- Switchery -->
<script src="{{ asset('js/switchery.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<!-- Parsley -->
<script src="{{ asset('js/parsley.min.js') }}"></script>
<!-- Autosize -->
<script src="{{ asset('js/autosize.min.js') }}"></script>
<!-- jQuery autocomplete -->
<script src="{{ asset('js/jquery.autocomplete.min.js') }}"></script>
<!-- starrr -->
<script src="{{ asset('js/starrr.js') }}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('js/custom.min.js') }}"></script>
<!-- FullCalendar -->
<script src="{{ asset('js/core/main.js') }}"></script>
<script src="{{ asset('js/interaction/main.js') }}"></script>
<script src="{{ asset('js/daygrid/main.js') }}"></script>
<script src="{{ asset('js/timegrid/main.js') }}"></script>
<!-- FontAwesome -->
<script src="{{ asset('js/all.min.js') }}"></script>
<!-- Dropzone.js -->
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<!-- Select Picker -->
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<!-- Sweet Alert -->
<script src="{{ asset('js/sweetalert2.all.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/responsive.bootstrap.js') }}"></script>
<script src="{{ asset('js/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('js/jszip.min.js') }}"></script>
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>