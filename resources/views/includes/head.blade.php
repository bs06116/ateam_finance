@section('head')
	<meta charset="utf-8" />
	<title>ATeam @yield('title')</title>
	<meta name="description" content="@yield('page_description')">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="assets/media/logos/favicon.png">
    @if (Request::path() == 'login' || Request::path() == 'reset')
    @else
    <?php
    $userlog = Auth::user()->email;
    $user = DB::table('users')->where('email', $userlog)->first();
    $account_type = $user ->type;
    if($account_type =='2') { } else {
    auth()->logout();
    ?>
    <meta http-equiv="refresh" content="0; URL='http://localhost/new_team/login?login=accountant'" />
    <div style="display: none;">
    <?php } ?>
    @endif
	<!--begin::Fonts -->

	<!--end::Fonts -->

	<!--begin::Page Vendors Styles(used by this page) -->
	<link href="{{ url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

	<!--end::Page Vendors Styles -->

	<!--begin::Global Theme Styles(used by all pages) -->
	<link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

	<!--end::Global Theme Styles -->

	<!--begin::Layout Skins(used by all pages) -->
	<link href="{{ url('assets/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('assets/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('assets/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('assets/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
@show


<!--end::Layout Skins -->
<!-- <link rel="shortcut icon" href="assets/media/logos/favicon.ico" /> -->

