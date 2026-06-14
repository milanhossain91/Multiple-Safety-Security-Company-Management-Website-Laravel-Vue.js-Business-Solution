<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('app.name', 'ATSL || Multiple development company in bangladesh') }}</title>

    <!-- Fav Icon -->
    <link rel="icon" href="{{URL::to('/')}}/img/logo.png" sizes="32x32" />
    <link rel="icon" href="{{URL::to('/')}}/img/logo.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{URL::to('/')}}/img/logo.png" />

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- ATSL professional admin theme refinements -->
    <link href="{{ asset('css/admin-custom.css') }}" rel="stylesheet">

     <!-- Custom styles for this page -->
     <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

     {{-- Tailwind CSS (utilities only — preflight disabled to avoid clashing with Bootstrap/SB Admin) --}}
     <script src="https://cdn.tailwindcss.com"></script>
     <script>tailwind.config = { corePlugins: { preflight: false } };</script>

     {{-- Per-page styles (page builder, menu builder, etc.) --}}
     @yield('styles')

</head>

<body class="@yield('body_class')">

    <!-- Page Wrapper -->
    <div id="wrapper">

      @yield('content')
      
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
     <!-- Page level plugins -->
     <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
 
     <!-- Page level custom scripts -->
     <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
     <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

     <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $('#summernote').summernote({
            placeholder: 'Enter your product description',
            tabsize: 2,
            height: 320,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>

    {{-- Per-page scripts (page builder, menu builder, etc.) --}}
    @yield('scripts')

</body>

</html>