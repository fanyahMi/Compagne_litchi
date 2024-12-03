<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('titre')</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>
<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->


	<!-- [ navigation menu ] start -->
        @include("template.sidebar.Menu")
	<!-- [ navigation menu ] end -->

	<!-- [ Header ] start -->
        @include("template.header.Header")
	<!-- [ Header ] end -->



<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        @yield('page')
    </div>
</div>
<!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src=" {{ url('assets/js/vendor-all.min.js') }}"></script>
    <script src=" {{ url('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src=" {{ url('assets/js/pcoded.min.js') }}"></script>

<!-- Apex Chart -->
@yield('script')

</body>

</html>
