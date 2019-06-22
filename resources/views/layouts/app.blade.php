<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{!empty($title) ? $title : ''}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}} ">
    <link rel="stylesheet" href="{{URL::asset('css/common.css')}} ">
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/common.js')}}"></script>
</head>
<body>
<div class="container">
    <div class="col-md-12 page-header">
        <h2>{{!empty($title) ? $title : ''}}</h2>
    </div>
    @yield('content')
</div>
</body>
</html>
