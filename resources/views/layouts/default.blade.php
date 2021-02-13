<!doctype html>
<html lang="{{App::getLocale()}}">
<head>
    @include('includes.head')
</head>
<body>

<header>
    @include('includes.header')
</header>

<main>
    @yield('mainHeader')
    <div class="s-container">
        @yield('content')
    </div>
</main>

<footer>
    @include('includes.footer')
</footer>

@include('includes.foot')
</body>
</html>