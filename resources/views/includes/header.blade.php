<div class="head-top bg_blue">
    <div class="s-container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div class="logo-col">
                        <h1 class="logo"><a href="{{route('index')}}"><img src="{{asset('img/png/logo.png')}}"></a></h1>
                    </div>
                    <div class="logo-col">
                        <h2 class="slogan text_white">
                            @lang('app.slogan')
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="head-bot bg_blue">
    <div class="s-container">
        <div class="row align-items-center">
            <nav class="col-lg-10 main-menu">
                <ul class="d-block-fix">
                    <li><a href="{{route('index')}}">@lang('Home')</a></li>
                    @if (Route::has('login'))
                        @auth
                            <li><a href="{{route('dashboard')}}">@lang('Dashboard')</a></li>
                        @else
                            <li><a href="{{route('login')}}">@lang('Login')</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{route('register')}}">@lang('Register')</a></li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>