<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tobazone</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="shortcut icon" href="/images/assets/icon.ico"> -->
    <link rel="shortcut icon" href="/images/assets/icon_1.png">

    <link rel="stylesheet" href="{{ url('/admin-assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/admin-assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('/admin-assets/vendors/themify-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ url('/admin-assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ url('/admin-assets/vendors/selectFX/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ url('/admin-assets/vendors/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/admin-assets/vendors/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/admin-assets/assets/css/summernote.css') }}">
    <link rel="stylesheet" href="{{ url('/admin-assets/assets/css/summernote-lite.css') }}">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('/admin-assets/assets/css/style.css')}}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
@include('admin.layouts.sidebar')

<div id="right-panel" class="right-panel">
    @include('admin.layouts.header')
    @yield('content')
</div>
@include('admin.layouts.script')

</body>
<script src="{{asset('/js/app.js')}}"></script>
</html>
