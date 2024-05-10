<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('settings.site_name', 'OAL') }} - @yield('title')</title>
    
    @laravelPWA

    <link rel="stylesheet" href="{{ asset('admin/css/vendor.styles.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/demo/legacy-template.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">

    <!-- inject:js -->
    <script src="{{ asset('admin/js/vendor.base.js') }}"></script>
    <script src="{{ asset('admin/js/vendor.bundle.js') }}"></script>
    <script src="{{ asset('common/js/axios.js') }}"></script>
    <script src="{{ asset('common/js/toastr.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/toastr.css') }}">
    
    <script src="{{ asset('common/js/sweet-alert.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/sweet-alert.css') }}">


    <script src="{{ asset('common/js/parsley.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('common/css/parsley.css') }}">
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    @yield('styles')

    <script type="text/javascript">
        var SITE_URL = "{{ url('/') }}/";
        var base_url = "{{ asset('/') }}";
    </script>
</head>
<body>
    
    <div id="overlay" style="display:none;"><div class="spinner"></div><br/>Please Wait...</div>

        @yield('content')


        <script src="{{ asset('admin/js/vendor-override/chartjs-doughnut.js') }}"></script>
        <script src="{{ asset('admin/js/vendor-override/tooltip.js') }}"></script>
        <script src="{{ asset('admin/js/components/legacy-sidebar/common.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('common/css/general.css') }}">
        <script src="{{ asset('common/js/general.js') }}"></script>

        @yield('scripts')
        
        <script>
            @if ($message = Session::get('success'))
                toastr.success("{{ $message }}");
            @endif

            @if ($message = Session::get('error'))
                 toastr.error("{{ $message }}");
            @endif

            @if ($message = Session::get('warning'))
                 toastr.warning("{{ $message }}");
            @endif

            @if ($message = Session::get('info'))
                 toastr.info("{{ $message }}");
            @endif
        </script>
    </body>
</html>
