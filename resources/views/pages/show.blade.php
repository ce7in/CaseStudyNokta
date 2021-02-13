@extends('layouts.default')

@section('mainHeader')
    <header>
        <nav class="breadcrumbs" aria-label="breadcrumbs">
            <ol itemscope itemtype="https://schema.org/BreadcrumbList" class="d-block-fix s-container">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
                    class="mr-2">
                    <a itemprop="item" href="{{route('index')}}">
                        <span itemprop="name">@lang('Home')</span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                ›
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="current ml-2">
                    <span itemprop="name">{{$city->name}}</span>
                    <meta itemprop="position" content="2"/>
                </li>
            </ol>
        </nav>

        <div class="top-more-special">
            <div class="s-container">
                <div class="row">
                    <div class="col-sm-6 text-sm-right">
                        <figure><img src="{{$city->current_response->condition->icon}}"
                                     alt="{{$city->current_response->condition->name}}"></figure>
                    </div>
                    <div class="col-sm-6 text-sm-left pl-0">
                        <p class="temperature">{{$city->current_response->forecast->temp}} <span>&#8451;</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h1 class="title-twe">{{$city->name}}, {{$city->country_code}}</h1>
                        <p class="description mt-20">{{$city->current_response->condition->name}}
                            , {{$city->current_response->condition->desc}}</p>
                        <p class="description mt-20">{{$city->current_response->datetime->formatted_date}} {{$city->current_response->datetime->formatted_time}}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 mb-50">
            <div class="white-box">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Pressure</th>
                        <td>{{$city->current_response->forecast->pressure}}</td>
                    </tr>
                    <tr>
                        <th>Humidity</th>
                        <td>{{$city->current_response->forecast->humidity}}</td>
                    </tr>
                    <tr>
                        <th>Sunrise</th>
                        <td>{{$city->current_response->datetime->formatted_sunrise}}</td>
                    </tr>
                    <tr>
                        <th>Sunset</th>
                        <td>{{$city->current_response->datetime->formatted_sunset}}</td>
                    </tr>
                    <tr>
                        <th>Geo Coords</th>
                        <td>[{{$city->current_response->location->latitude}}
                            , {{$city->current_response->location->latitude}}]
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8 mb-50">
            <div class="white-box p-3">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .highcharts-figure, .highcharts-data-table table {
            min-width: 310px;
            width: 100%;
            margin: auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
@endsection

@section('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Weather and Forecasts in {{$city->name}}, {{$city->country_code}}'
            },
            subtitle: {
                text: 'Source: OpenWeatherMap.org'
            },
            xAxis: {
                categories: [@php($i = 0) @foreach($city->forecast_response->forecast as $forecast)'{{$forecast->datetime->formatted_time}}', @if($i >= 10) @break @endif @php($i++) @endforeach]
            },
            yAxis: {
                title: {
                    text: 'Temperature'
                },
                labels: {
                    formatter: function () {
                        return this.value + '°';
                    }
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [{
                name: '{{$city->name}}, {{$city->country_code}}',
                marker: {
                    symbol: 'square'
                },
                data: [
                        @php($i = 0)
                        {
                            y: 6,
                            marker: {
                                symbol: 'url(https://www.highcharts.com/samples/graphics/snow.png)'
                            }
                        },
                        @foreach($city->forecast_response->forecast as $forecast)
                            {
                                y: {{$forecast->forecast->temp}},
                                marker: {
                                    symbol: 'url({{$forecast->condition->icon}})'
                                }
                            },

                            @if($i >= 10)
                                @break
                            @endif

                            @php($i++)
                        @endforeach
                ]
            }]
        });
    </script>
@endsection