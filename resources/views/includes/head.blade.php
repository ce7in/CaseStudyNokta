<title>{{$title}}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="{{$meta['keywords']}}">
<meta name="description" content="{{$meta['description']}}">
<link rel="icon" type="image/png" href="{{$favicon ?: rootAsset('img/favicon.png')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/all.css')}}">
@hasSection('style')
    @yield('style')
@endif