<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('../backend/assets/images/favicon.png') }}">
    <title>Button</title>
    <!-- Custom CSS -->
    {{-- <link href="../backend/assets/libs/flot/css/float-chart.css" rel="stylesheet"> --}}
    <link href="{{ URL::asset('../backend/assets/libs/flot/css/float-chart.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('../css/backend_css/custom_css.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ URL::asset('../backend/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    {{-- /var/www/button/public/backend/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css --}}
    <!-- Custom CSS -->
    <link href="{{ URL::asset('../css/backend_css/style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        @include('admin.includes.admin_header')
        @include('admin.includes.admin_sidebar')
        <div class="page-wrapper">
            @include('admin.includes.flash_messages')
            @include('admin.includes.breadcrumb', ['path' => Request::path(), 'parent' => 'dashboard'])
            
            @yield('content')

            @include('admin.includes.admin_footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ URL::asset('../backend/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ URL::asset('../backend/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ URL::asset('../js/backend_js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ URL::asset('../js/backend_js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ URL::asset('../js/backend_js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!-- <script src="{{ URL::asset('../js/backend_js/pages/dashboards/dashboard1.js"></') }}script> -->
    <!-- Charts js Files -->
    {{-- TODO THere is a conflict with datepicker --}}
    <script src="{{asset('js/app.js')}}" ></script>
    
    <script src="{{ URL::asset('../backend/assets/libs/flot/excanvas.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ URL::asset('../js/backend_js/pages/chart/chart-page-init.js') }}"></script>
    <script src="{{ URL::asset('../backend/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    
    
    <script>    
        /*datwpicker*/
        jQuery('.mydatepicker').datepicker({format: 'dd-mm-yyyy', todayHighlight: true});
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

    </script>

</body>

</html>