<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a New City') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    <form method="POST" action="{{ route('dashboard.cities.store') }}">
                        @csrf

                        <div>
                            <x-label for="country_code" :value="__('Country Code')"/>

                            <x-input id="country_code" class="block mt-1 w-full" type="text" name="country_code" :value="old('country_code')"
                                     required autofocus/>
                        </div>

                        <div class="mt-4">
                            <x-label for="name" :value="__('City Name')"/>

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                     required/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Add New') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
