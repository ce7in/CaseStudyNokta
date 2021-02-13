@extends('layouts.default')

@section('content')
    <!-- main content -->
    <div class="main-col hasShadow" style="border-top-left-radius: 0">
        <div class="main-col-pad">
            <section class="bar mb-30 mt-30">
                <nav>
                    <ul class="row no-gutters home-city-button d-block-fix">
                        @foreach($cities as $city)
                            <li class="col-lg-3 col-6 p-3">
                                <a href="{{route('cities.show', [$city->id])}}" title="{{$city->name}}" class="white-box">
                                    {{$city->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </section>
        </div>
    </div>
@endsection