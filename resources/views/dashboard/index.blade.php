<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!$cities)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{__('There is no city in the database. Add a new one by using link "Add City" on the nav bar.')}}
                    </div>
                </div>
            @else
                @foreach($cities as $city)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                        <div class="p-6 bg-white border-b border-gray-200">
                            {{$city->name}}
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
</x-app-layout>
