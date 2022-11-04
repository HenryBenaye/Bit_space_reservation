
<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <p>Maak een nieuwe reservering</p>
        </x-slot>

        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf
            <!-- Space -->
            <div>
                <x-input-label for="space_name" :value="__('Space')" />
                <select name="space_name" id="space_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($spaces as $space)
                        <option  value="{{$space->name}}">{{$space->name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- TimeRule -->
            <div class="begin_time_box mt-4">
                <x-input-label for="begin_time" :value="__('Begin tijd')"  />

                <select class="rounded-md mt-1 shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="begin_time_hour" id="begin_time_hour">
                    @for($x = 8; $x <= 17; $x++)
                        <option  value="{{$x}}">{{$x}}</option>
                    @endfor
                </select>
                <select class="rounded-md mt-1 shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="begin_time_minute" id="begin_time_minute">
                    @for($x = 00; $x <= 45; $x+=15)
                        <option value="{{$x}}" {{ $x != 30 ?: "selected"}}>{{$x}}</option>
                    @endfor
                </select>
            </div>

            <div class="end_time_box mt-4">
                <x-input-label for="end_time" :value="__('Eind tijd')" />

                <select class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="end_time_hour" id="end_time_hour">
                    @for($x = 8; $x <= 17; $x++)
                        <option value="{{$x}}">{{$x}}</option>
                    @endfor
                </select>
                <select class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="end_time_minute" id="end_time_minute">
                    @for($x = 00; $x <= 45; $x+=15)
                        <option value="{{$x}}" {{ $x != 45 ?: "selected"}}>{{$x}}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-error-message>

                </x-error-message>
                <x-primary-button class="ml-4">
                    {{ __('Klaar') }}
                </x-primary-button>
            </div>


        </form>
    </x-auth-card>
</x-app-layout>
